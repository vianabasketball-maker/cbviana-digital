// CBV APOSTAS — v1.0
// WPCode PHP snippet — adicionar como novo snippet em WPCode > PHP Snippets

// ─── CONSTANTES ───────────────────────────────────────────────────────────────
if ( ! defined('CBV_AP_CLUBE_ID') ) {
    define('CBV_AP_CLUBE_ID',   '723');
    define('CBV_AP_VIANA_PAT',  'VIA');
    define('CBV_AP_STATS_FILE', ABSPATH . 'data_apostas/ap_stats.json');
    define('CBV_AP_STATS_TTL',  86400);
    define('CBV_AP_EPOCA',      '2025/2026');
    define('CBV_AP_MAX_APOSTA', 10);
    define('CBV_AP_BETS_KEY',   'cbv_apostas_v1');
}

// ─── FETCH COM CACHE ──────────────────────────────────────────────────────────
function cbv_ap_fetch($url, $cache_file, $ttl = 3600) {
    $dir = dirname($cache_file);
    if (!file_exists($dir)) mkdir($dir, 0755, true);
    if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $ttl) {
        return file_get_contents($cache_file);
    }
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_ENCODING       => '',
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
    ]);
    $res  = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($res && $code === 200 && strlen($res) > 3000) {
        file_put_contents($cache_file, $res);
        return $res;
    }
    return file_exists($cache_file) ? file_get_contents($cache_file) : '';
}

// ─── PARSE HTML FPB → ARRAY DE JOGOS ─────────────────────────────────────────
// Funciona tanto para resultados como para calendário
function cbv_ap_parse_fpb($html) {
    $jogos = [];
    if (!$html || strlen($html) < 1000) return $jogos;

    $ma = ['JAN'=>'01','FEV'=>'02','MAR'=>'03','ABR'=>'04','MAI'=>'05',
           'JUN'=>'06','JUL'=>'07','AGO'=>'08','SET'=>'09','OUT'=>'10',
           'NOV'=>'11','DEZ'=>'12'];

    preg_match_all('/<div class="day-wrapper[^"]*">(.*?)<\/div>\s*<!-- END DAY ROW/si', $html, $days);

    foreach ($days[1] as $db) {
        // Data do dia
        preg_match('/<h3 class="date">\s*(.*?)\s*<\/h3>/si', $db, $dm);
        $data_raw = isset($dm[1]) ? trim(strip_tags($dm[1])) : '';
        $ts = false;
        if (preg_match('/(\d{1,2})\s+([A-Z]{3})\s+(\d{4})/u', strtoupper($data_raw), $tm)) {
            $ts = strtotime($tm[3].'-'.($ma[$tm[2]]??'01').'-'.str_pad($tm[1],2,'0',STR_PAD_LEFT));
        }

        preg_match_all('/href="(\/ficha-de-jogo[^"]*)"[^>]*>\s*<div class="game-wrapper([^"]*)">(.*?)<\/div>\s*<\/a>/si', $db, $games);

        foreach ($games[3] as $idx => $gb) {
            $tem_resultado = strpos($games[2][$idx], 'results') !== false;

            // Siglas — tenta sigla primeiro, fallback para name
            preg_match_all('/<span class="sigla">([^<]+)<\/span>/i', $gb, $sigs);
            if (count($sigs[1]) < 2) {
                preg_match_all('/<span class="name">([^<]+)<\/span>/i', $gb, $sigs);
            }
            $sc = trim($sigs[1][0] ?? '');
            $sf = trim($sigs[1][1] ?? '');
            if (!$sc || !$sf) continue;

            // IDs + logos — extrai todos e identifica CBV vs adversário
            preg_match_all('/CLU_(\d+)_LOGO/i', $gb, $ids);
            $todos_ids = array_unique($ids[1]);
            preg_match_all('/src="(https?:\/\/[^"]*CLU_(\d+)_LOGO[^"]*)"/i', $gb, $logos_m);
            $logo_map = [];
            foreach ($logos_m[2] as $li => $lid) { $logo_map[$lid] = $logos_m[1][$li]; }

            $id_cbv = CBV_AP_CLUBE_ID;
            $is_cbv_casa = (isset($todos_ids[0]) && $todos_ids[0] === $id_cbv)
                        || stripos($sc, 'viana') !== false
                        || stripos($sc, 'cbv') !== false;
            $logo_cbv = $logo_map[$id_cbv] ?? ('https://sav2.fpb.pt/old_uploads/CLU/CLU_'.$id_cbv.'_LOGO.jpg');

            if ($is_cbv_casa) {
                $id_casa = $id_cbv; $logo_casa = $logo_cbv;
                $id_fora = ''; $logo_fora = '';
                foreach ($todos_ids as $tid) {
                    if ($tid !== $id_cbv) { $id_fora = $tid; $logo_fora = $logo_map[$tid] ?? ''; break; }
                }
            } else {
                $id_fora = $id_cbv; $logo_fora = $logo_cbv;
                $id_casa = ''; $logo_casa = '';
                foreach ($todos_ids as $tid) {
                    if ($tid !== $id_cbv) { $id_casa = $tid; $logo_casa = $logo_map[$tid] ?? ''; break; }
                }
                if (!$id_casa && isset($todos_ids[0])) {
                    $id_casa = $todos_ids[0]; $logo_casa = $logo_map[$id_casa] ?? '';
                }
            }

            // Hora
            $hora = '';
            if (preg_match('/<div[^>]*class="hour[^"]*"[^>]*>\s*<h3>\s*([^<]+)\s*<\/h3>/si', $gb, $hm)) {
                $hora = trim(preg_replace('/\s+/', '', $hm[1]));
                if (preg_match('/^(\d{1,2})H(\d{2})$/i', $hora, $hc)) $hora = $hc[1].':'.$hc[2];
            }

            // Competição
            $comp = '';
            if (preg_match('/class="competition"[^>]*>.*?<span>\s*(.*?)\s*<\/span>/si', $gb, $cm)) {
                $comp = trim(strip_tags($cm[1]));
            }

            // Scores (só se tiver resultado)
            $score_casa = null;
            $score_fora = null;
            $vencedor   = null;
            if ($tem_resultado) {
                preg_match('/<div[^>]*class="[^"]*results_wrapper[^"]*"[^>]*>(.*?)<\/div>/si', $gb, $rw);
                if (isset($rw[1])) {
                    preg_match_all('/<h3[^>]*>\s*(\d+)\s*<\/h3>/i', $rw[1], $sc_arr);
                    $score_casa = isset($sc_arr[1][0]) ? intval($sc_arr[1][0]) : null;
                    $score_fora = isset($sc_arr[1][1]) ? intval($sc_arr[1][1]) : null;
                    if ($score_casa !== null && $score_fora !== null) {
                        $vencedor = $score_casa > $score_fora ? 'casa' : 'fora';
                    }
                }
            }

            // Link
            $link = 'https://www.fpb.pt' . $games[1][$idx];

            $jogos[] = [
                'ts'          => $ts,
                'data'        => $data_raw,
                'hora'        => $hora,
                'sigla_casa'  => $sc,
                'sigla_fora'  => $sf,
                'id_casa'     => $id_casa,
                'id_fora'     => $id_fora,
                'logo_casa'   => $logo_casa,
                'logo_fora'   => $logo_fora,
                'comp'        => $comp,
                'link'        => $link,
                'tem_resultado'=> $tem_resultado,
                'score_casa'  => $score_casa,
                'score_fora'  => $score_fora,
                'vencedor'    => $vencedor,
            ];
        }
    }
    return $jogos;
}

// ─── MAPA SIGLA → LOGO (extrai todos os logos conhecidos dos resultados) ────────
function cbv_ap_logo_map() {
    $dir = ABSPATH . 'data_apostas/';
    $map_file = $dir . 'ap_logomap.json';
    if (file_exists($map_file) && (time() - filemtime($map_file)) < 86400) {
        $d = json_decode(file_get_contents($map_file), true);
        if ($d) return $d;
    }
    $html = cbv_ap_fetch(
        'https://www.fpb.pt/resultados/clube_'.CBV_AP_CLUBE_ID.'/?clube='.CBV_AP_CLUBE_ID.'&epoca='.urlencode(CBV_AP_EPOCA),
        $dir . 'ap_res.html', 3600
    );
    $cal_html = cbv_ap_fetch(
        'https://www.fpb.pt/calendario/clube_'.CBV_AP_CLUBE_ID.'/?clube='.CBV_AP_CLUBE_ID.'&epoca='.urlencode(CBV_AP_EPOCA),
        $dir . 'ap_cal.html', 3600
    );
    $map = [];
    // Processa HTML extraindo img com alt="Logo X" e src="URL"
    foreach ([$html, $cal_html] as $h) {
        if (!$h) continue;
        // Extrai todas as tags <img ...>
        preg_match_all('/<img[^>]+>/si', $h, $img_tags);
        foreach ($img_tags[0] as $tag) {
            // alt pode ter espaço extra no fim: alt="Logo Monção BC "
            if (!preg_match('/alt="Logo\s+([^"]+?)\s*"/i', $tag, $am)) continue;
            $sigla = trim($am[1]);
            if (!preg_match('/src="([^"]+)"/i', $tag, $sm)) continue;
            $url = trim($sm[1]);
            if ($sigla && $url) {
                $map[strtolower($sigla)] = $url;
            }
        }
    }
    file_put_contents($map_file, json_encode($map, JSON_UNESCAPED_UNICODE));
    return $map;
}

function cbv_ap_get_logo($sigla, $logo_map, $fallback = '') {
    $key = strtolower(trim($sigla));
    // Match exato primeiro
    if (isset($logo_map[$key])) return $logo_map[$key];
    // Match parcial — ordena por comprimento DESC para matches mais específicos ganharem
    // Ex: "basquete barcelos sub23" ganha sobre "basquete barcelos"
    $candidatos = [];
    foreach ($logo_map as $k => $v) {
        if ($k === 'cb viana' || $k === 'clube') continue; // ignora chaves genéricas
        if (strpos($key, $k) !== false || strpos($k, $key) !== false) {
            $candidatos[strlen($k)] = $v;
        }
    }
    if ($candidatos) {
        krsort($candidatos); // maior comprimento primeiro
        return reset($candidatos);
    }
    return $fallback ?: 'https://sav2.fpb.pt/old_uploads/CLU/CLU_'.CBV_AP_CLUBE_ID.'_LOGO.jpg';
}

// ─── CALCULAR + GUARDAR STATS DAS EQUIPAS ────────────────────────────────────
// Para cada equipa adversária faz fetch dos seus resultados na FPB
// e calcula: jogos, vitórias, derrotas, winRate
function cbv_ap_atualizar_stats() {
    $dir = ABSPATH . 'data_apostas/';

    // 1. Resultados do CB Viana → extrai IDs dos adversários
    $res_html = cbv_ap_fetch(
        'https://www.fpb.pt/resultados/clube_'.CBV_AP_CLUBE_ID.'/?clube='.CBV_AP_CLUBE_ID.'&epoca='.urlencode(CBV_AP_EPOCA),
        $dir . 'ap_res.html',
        3600
    );

    $jogos_viana = cbv_ap_parse_fpb($res_html);

    // Extrai adversários únicos (sigla + id)
    $adversarios = [];
    foreach ($jogos_viana as $j) {
        $is_casa = stripos($j['sigla_casa'], CBV_AP_VIANA_PAT) !== false
                || $j['id_casa'] === CBV_AP_CLUBE_ID;
        if ($is_casa && $j['id_fora']) {
            $adversarios[$j['id_fora']] = [
                'sigla' => $j['sigla_fora'],
                'logo'  => $j['logo_fora'],
            ];
        } elseif (!$is_casa && $j['id_casa']) {
            $adversarios[$j['id_casa']] = [
                'sigla' => $j['sigla_casa'],
                'logo'  => $j['logo_casa'],
            ];
        }
    }

    // Inclui sempre o CB Viana
    $adversarios[CBV_AP_CLUBE_ID] = [
        'sigla' => 'CBV',
        'logo'  => 'https://sav2.fpb.pt/old_uploads/CLU/CLU_'.CBV_AP_CLUBE_ID.'_LOGO.jpg',
    ];

    // 2. Para cada clube (incluindo CBV) → fetch resultados → conta V/D
    $stats = [];
    foreach ($adversarios as $clube_id => $info) {
        $cache_file = $dir . 'ap_res_' . $clube_id . '.html';
        $url = 'https://www.fpb.pt/resultados/clube_'.$clube_id.'/?clube='.$clube_id.'&epoca='.urlencode(CBV_AP_EPOCA);
        $html = cbv_ap_fetch($url, $cache_file, CBV_AP_STATS_TTL);

        $jogos = cbv_ap_parse_fpb($html);

        $total    = 0;
        $vitorias = 0;
        $derrotas = 0;

        foreach ($jogos as $j) {
            if (!$j['tem_resultado'] || $j['vencedor'] === null) continue;

            $e_casa = stripos($j['sigla_casa'], $info['sigla']) !== false
                   || $j['id_casa'] === (string)$clube_id;

            $ganhou = ($e_casa && $j['vencedor'] === 'casa')
                   || (!$e_casa && $j['vencedor'] === 'fora');

            $total++;
            if ($ganhou) $vitorias++;
            else         $derrotas++;
        }

        // Fallback se não tiver jogos suficientes
        if ($total < 3) {
            $total    = 10;
            $vitorias = 5;
            $derrotas = 5;
        }

        $stats[$clube_id] = [
            'sigla'    => $info['sigla'],
            'logo'     => $info['logo'],
            'jogos'    => $total,
            'vitorias' => $vitorias,
            'derrotas' => $derrotas,
            'winRate'  => round($vitorias / $total, 4),
        ];
    }

    // 3. Guarda JSON
    file_put_contents(CBV_AP_STATS_FILE, json_encode($stats, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    return $stats;
}

// ─── LER STATS (com cache 24h) ────────────────────────────────────────────────
function cbv_ap_get_stats_cached() {
    if (file_exists(CBV_AP_STATS_FILE) && (time() - filemtime(CBV_AP_STATS_FILE)) < CBV_AP_STATS_TTL) {
        $data = json_decode(file_get_contents(CBV_AP_STATS_FILE), true);
        if ($data && count($data) > 0) return $data;
    }
    return cbv_ap_atualizar_stats();
}

// ─── CALCULAR ODDS ────────────────────────────────────────────────────────────
function cbv_ap_calcular_odds($wr_casa, $wr_fora) {
    $total = $wr_casa + $wr_fora;
    if ($total <= 0) { $wr_casa = 0.5; $wr_fora = 0.5; $total = 1; }
    $pct_casa = $wr_casa / $total;
    $pct_fora = $wr_fora / $total;
    // Margem da casa de 10%
    $odd_casa = round(max(1.05, (1 / $pct_casa) * 0.90), 2);
    $odd_fora = round(max(1.05, (1 / $pct_fora) * 0.90), 2);
    return [
        'odd_casa'  => $odd_casa,
        'odd_fora'  => $odd_fora,
        'pct_casa'  => round($pct_casa * 100),
        'pct_fora'  => round($pct_fora * 100),
    ];
}

// ─── APOSTAS: LER / ESCREVER ─────────────────────────────────────────────────
function cbv_ap_get_todas_apostas() {
    $data = get_option(CBV_AP_BETS_KEY, []);
    return is_array($data) ? $data : [];
}

function cbv_ap_guardar_apostas($apostas) {
    update_option(CBV_AP_BETS_KEY, $apostas, false);
}

// ─── ENDPOINTS REST ───────────────────────────────────────────────────────────
add_action('rest_api_init', function() {

    // GET /cbv/v1/apostas/stats — win rates de todas as equipas
    register_rest_route('cbv/v1', '/apostas/stats', [
        'methods'             => 'GET',
        'permission_callback' => '__return_true',
        'callback'            => function() {
            return rest_ensure_response(cbv_ap_get_stats_cached());
        },
    ]);

    // GET /cbv/v1/apostas/jogos — jogos futuros com odds
    register_rest_route('cbv/v1', '/apostas/jogos', [
        'methods'             => 'GET',
        'permission_callback' => '__return_true',
        'callback'            => function() {
            $dir  = ABSPATH . 'data_apostas/';
            $html = cbv_ap_fetch(
                'https://www.fpb.pt/calendario/clube_'.CBV_AP_CLUBE_ID.'/?clube='.CBV_AP_CLUBE_ID.'&epoca='.urlencode(CBV_AP_EPOCA),
                $dir . 'ap_cal.html',
                3600
            );
            $jogos    = cbv_ap_parse_fpb($html);
            $stats    = cbv_ap_get_stats_cached();
            $logo_map = cbv_ap_logo_map();
            $hoje     = strtotime(date('Y-m-d'));
            $resultado = [];

            foreach ($jogos as $j) {
                if (!$j['ts'] || $j['ts'] < $hoje) continue;
                if ($j['tem_resultado']) continue;

                // Usa sempre o logo_map pela sigla — fonte mais fiável que o parser
                $logo_fb   = 'https://sav2.fpb.pt/old_uploads/CLU/CLU_'.CBV_AP_CLUBE_ID.'_LOGO.jpg';
                $logo_casa = cbv_ap_get_logo($j['sigla_casa'], $logo_map, $j['logo_casa'] ?: $logo_fb);
                $logo_fora = cbv_ap_get_logo($j['sigla_fora'], $logo_map, $j['logo_fora'] ?: $logo_fb);

                // Win rates
                $wr_casa = isset($stats[$j['id_casa']]) ? $stats[$j['id_casa']]['winRate'] : 0.50;
                $wr_fora = isset($stats[$j['id_fora']]) ? $stats[$j['id_fora']]['winRate'] : 0.50;
                $odds    = cbv_ap_calcular_odds($wr_casa, $wr_fora);

                // Stats das equipas
                $stats_casa = $stats[$j['id_casa']] ?? ['sigla'=>$j['sigla_casa'],'logo'=>$logo_casa,'jogos'=>0,'vitorias'=>0,'derrotas'=>0,'winRate'=>0.5];
                $stats_fora = $stats[$j['id_fora']] ?? ['sigla'=>$j['sigla_fora'],'logo'=>$logo_fora,'jogos'=>0,'vitorias'=>0,'derrotas'=>0,'winRate'=>0.5];

                $resultado[] = [
                    'id'          => md5($j['link']),
                    'link'        => $j['link'],
                    'ts'          => $j['ts'],
                    'data'        => $j['data'],
                    'hora'        => $j['hora'],
                    'comp'        => $j['comp'],
                    'sigla_casa'  => $j['sigla_casa'],
                    'sigla_fora'  => $j['sigla_fora'],
                    'id_casa'     => $j['id_casa'],
                    'id_fora'     => $j['id_fora'],
                    'logo_casa'   => $logo_casa,
                    'logo_fora'   => $logo_fora,
                    'odd_casa'    => $odds['odd_casa'],
                    'odd_fora'    => $odds['odd_fora'],
                    'pct_casa'    => $odds['pct_casa'],
                    'pct_fora'    => $odds['pct_fora'],
                    'stats_casa'  => $stats_casa,
                    'stats_fora'  => $stats_fora,
                ];
            }

            usort($resultado, fn($a,$b) => $a['ts'] - $b['ts']);
            return rest_ensure_response($resultado);
        },
    ]);

    // GET /cbv/v1/apostas/minhas — apostas do utilizador autenticado
    register_rest_route('cbv/v1', '/apostas/minhas', [
        'methods'             => 'GET',
        'permission_callback' => '__return_true',
        'callback'            => function() {
            if (!is_user_logged_in()) return new WP_Error('not_logged_in', 'Não autenticado', ['status'=>401]);
            $uid    = get_current_user_id();
            $todas  = cbv_ap_get_todas_apostas();
            $minhas = array_values(array_filter($todas, fn($a) => $a['uid'] === $uid));
            return rest_ensure_response($minhas);
        },
    ]);

    // POST /cbv/v1/apostas/cancelar — cancelar aposta pendente
    register_rest_route('cbv/v1', '/apostas/cancelar', [
        'methods'             => 'POST',
        'permission_callback' => '__return_true',
        'callback'            => function($req) {
            if (!is_user_logged_in()) return new WP_Error('not_logged_in', 'Não autenticado', ['status'=>401]);
            $uid       = get_current_user_id();
            $aposta_id = sanitize_text_field($req->get_param('aposta_id'));
            if (!$aposta_id) return new WP_Error('invalid', 'ID inválido', ['status'=>400]);

            $todas = cbv_ap_get_todas_apostas();
            $found = false;
            foreach ($todas as &$a) {
                if ($a['id'] !== $aposta_id) continue;
                if ($a['uid'] !== $uid) return new WP_Error('forbidden', 'Sem permissão', ['status'=>403]);
                if ($a['estado'] !== 'pendente') return new WP_Error('invalid', 'Aposta já resolvida', ['status'=>400]);
                // Devolve moedas
                $moedas = (int) get_user_meta($uid, 'cbv_moedas', true);
                update_user_meta($uid, 'cbv_moedas', $moedas + $a['montante']);
                $a['estado']       = 'cancelada';
                $a['resolvida_em'] = time();
                $found = true;
                $moedas_novas = $moedas + $a['montante'];
                break;
            }
            unset($a);
            if (!$found) return new WP_Error('not_found', 'Aposta não encontrada', ['status'=>404]);
            cbv_ap_guardar_apostas($todas);
            return rest_ensure_response([
                'sucesso' => true,
                'moedas'  => $moedas_novas,
            ]);
        },
    ]);

    // POST /cbv/v1/apostas/apostar — colocar aposta
    register_rest_route('cbv/v1', '/apostas/apostar', [
        'methods'             => 'POST',
        'permission_callback' => '__return_true',
        'callback'            => function($req) {
            if (!is_user_logged_in()) return new WP_Error('not_logged_in', 'Não autenticado', ['status'=>401]);
            $uid = get_current_user_id();
            $jogo_id  = sanitize_text_field($req->get_param('jogo_id'));
            $escolha  = sanitize_text_field($req->get_param('escolha')); // 'casa' ou 'fora'
            $montante = intval($req->get_param('montante'));

            // Validações
            if (!$jogo_id || !in_array($escolha, ['casa','fora'])) {
                return new WP_Error('invalid', 'Dados inválidos', ['status'=>400]);
            }
            if ($montante < 1 || $montante > CBV_AP_MAX_APOSTA) {
                return new WP_Error('invalid', 'Montante inválido (1-'.CBV_AP_MAX_APOSTA.')', ['status'=>400]);
            }

            // Verificar se já apostou neste jogo
            $todas = cbv_ap_get_todas_apostas();
            foreach ($todas as $a) {
                if ($a['uid'] === $uid && $a['jogo_id'] === $jogo_id && $a['estado'] === 'pendente') {
                    return new WP_Error('duplicate', 'Já apostaste neste jogo', ['status'=>400]);
                }
            }

            // Verificar e descontar moedas
            // Se cbvgam_paid=true, o CBVGam já descontou — só valida, não desconta de novo
            $cbvgam_paid = (bool) $req->get_param('cbvgam_paid');
            $moedas = (int) get_user_meta($uid, 'cbv_moedas', true);
            if ($moedas < 0) $moedas = 0;
            if (!$cbvgam_paid) {
                // CBVGam não descontou — desconta aqui
                if ($moedas < $montante) {
                    return new WP_Error('insufficient', 'Moedas insuficientes', ['status'=>400]);
                }
                $moedas -= $montante;
                update_user_meta($uid, 'cbv_moedas', $moedas);
            }
            // Se cbvgam_paid=true, o CBVGam já descontou do user_meta, não faz nada

            // Buscar odds do jogo
            $odd = 1.5; // fallback
            $dir  = ABSPATH . 'data_apostas/';
            $html = cbv_ap_fetch(
                'https://www.fpb.pt/calendario/clube_'.CBV_AP_CLUBE_ID.'/?clube='.CBV_AP_CLUBE_ID.'&epoca='.urlencode(CBV_AP_EPOCA),
                $dir . 'ap_cal.html', 3600
            );
            $jogos = cbv_ap_parse_fpb($html);
            $stats = cbv_ap_get_stats_cached();
            foreach ($jogos as $j) {
                if (md5($j['link']) === $jogo_id) {
                    $wr_casa = isset($stats[$j['id_casa']]) ? $stats[$j['id_casa']]['winRate'] : 0.5;
                    $wr_fora = isset($stats[$j['id_fora']]) ? $stats[$j['id_fora']]['winRate'] : 0.5;
                    $odds    = cbv_ap_calcular_odds($wr_casa, $wr_fora);
                    $odd     = $escolha === 'casa' ? $odds['odd_casa'] : $odds['odd_fora'];
                    break;
                }
            }

            // Guardar aposta
            // Encontra timestamp do jogo para lógica de devolução (48h sem resultado)
            $ts_jogo = 0;
            foreach ($jogos as $jg) {
                if (md5($jg['link']) === $jogo_id) { $ts_jogo = $jg['ts'] ?: 0; break; }
            }

            $aposta = [
                'id'        => uniqid('ap_'),
                'uid'       => $uid,
                'username'  => wp_get_current_user()->display_name,
                'jogo_id'   => $jogo_id,
                'escolha'   => $escolha,
                'montante'  => $montante,
                'odd'       => $odd,
                'retorno_potencial' => floor($montante * $odd),
                'estado'    => 'pendente',
                'ts_jogo'   => $ts_jogo,
                'criada_em' => time(),
                'resolvida_em' => null,
                'ganhou'    => null,
                'payout'    => null,
                'notificado'=> false,
            ];
            $todas[] = $aposta;
            cbv_ap_guardar_apostas($todas);

            return rest_ensure_response([
                'sucesso'           => true,
                'aposta'            => $aposta,
                'moedas_restantes'  => $moedas,
                'retorno_potencial' => $aposta['retorno_potencial'],
            ]);
        },
    ]);

    // POST /cbv/v1/apostas/resolver — resolver apostas com resultados reais (admin)
    register_rest_route('cbv/v1', '/apostas/resolver', [
        'methods'             => 'POST',
        'permission_callback' => function() { return current_user_can('manage_options'); },
        'callback'            => function() {
            $dir      = ABSPATH . 'data_apostas/';
            // Força re-fetch dos resultados
            @unlink($dir . 'ap_res.html');
            $res_html = cbv_ap_fetch(
                'https://www.fpb.pt/resultados/clube_'.CBV_AP_CLUBE_ID.'/?clube='.CBV_AP_CLUBE_ID.'&epoca='.urlencode(CBV_AP_EPOCA),
                $dir . 'ap_res.html', 0
            );
            $resultados = cbv_ap_parse_fpb($res_html);

            // Índice: jogo_id → vencedor
            $res_idx = [];
            foreach ($resultados as $r) {
                if ($r['tem_resultado'] && $r['vencedor']) {
                    $res_idx[md5($r['link'])] = $r['vencedor'];
                }
            }

            $todas     = cbv_ap_get_todas_apostas();
            $resolvidas = 0;
            $pagas      = 0;

            foreach ($todas as &$aposta) {
                if ($aposta['estado'] !== 'pendente') continue;
                if (!isset($res_idx[$aposta['jogo_id']])) continue;

                $vencedor = $res_idx[$aposta['jogo_id']];
                $ganhou   = $aposta['escolha'] === $vencedor;
                $payout   = $ganhou ? floor($aposta['montante'] * $aposta['odd']) : 0;

                $aposta['estado']       = $ganhou ? 'ganha' : 'perdida';
                $aposta['ganhou']       = $ganhou;
                $aposta['payout']       = $payout;
                $aposta['resolvida_em'] = time();

                if ($ganhou && $payout > 0) {
                    $moedas_atual = (int) get_user_meta($aposta['uid'], 'cbv_moedas', true);
                    update_user_meta($aposta['uid'], 'cbv_moedas', $moedas_atual + $payout);
                    $pagas++;
                }
                $resolvidas++;
            }
            unset($aposta);

            cbv_ap_guardar_apostas($todas);

            return rest_ensure_response([
                'sucesso'    => true,
                'resolvidas' => $resolvidas,
                'pagas'      => $pagas,
            ]);
        },
    ]);

    // POST /cbv/v1/apostas/atualizar-stats — força re-fetch das stats (admin)
    register_rest_route('cbv/v1', '/apostas/atualizar-stats', [
        'methods'             => 'POST',
        'permission_callback' => function() { return current_user_can('manage_options'); },
        'callback'            => function() {
            @unlink(CBV_AP_STATS_FILE);
            $stats = cbv_ap_atualizar_stats();
            return rest_ensure_response([
                'sucesso' => true,
                'equipas' => count($stats),
                'stats'   => $stats,
            ]);
        },
    ]);

});


// ─── CRON AUTOMÁTICO — resolve apostas diariamente ───────────────────────────
add_action('cbv_apostas_cron', 'cbv_ap_cron_resolver');
function cbv_ap_cron_resolver() {
    $dir = ABSPATH . 'data_apostas/';
    // Força re-fetch resultados
    @unlink($dir . 'ap_res.html');
    $res_html = cbv_ap_fetch(
        'https://www.fpb.pt/resultados/clube_'.CBV_AP_CLUBE_ID.'/?clube='.CBV_AP_CLUBE_ID.'&epoca='.urlencode(CBV_AP_EPOCA),
        $dir . 'ap_res.html', 0
    );
    $resultados = cbv_ap_parse_fpb($res_html);
    $res_idx = [];
    foreach ($resultados as $r) {
        if ($r['tem_resultado'] && $r['vencedor']) {
            $res_idx[md5($r['link'])] = $r['vencedor'];
        }
    }
    $todas = cbv_ap_get_todas_apostas();
    $dir2  = ABSPATH . 'data_apostas/';
    $cal_html = cbv_ap_fetch(
        'https://www.fpb.pt/calendario/clube_'.CBV_AP_CLUBE_ID.'/?clube='.CBV_AP_CLUBE_ID.'&epoca='.urlencode(CBV_AP_EPOCA),
        $dir2 . 'ap_cal.html', 3600
    );
    $jogos_cal = cbv_ap_parse_fpb($cal_html);
    $stats = cbv_ap_get_stats_cached();
    $logo_map = cbv_ap_logo_map();
    $logo_fb  = 'https://sav2.fpb.pt/old_uploads/CLU/CLU_'.CBV_AP_CLUBE_ID.'_LOGO.jpg';

    $agora = time();
    foreach ($todas as &$aposta) {
        if ($aposta['estado'] !== 'pendente') continue;

        // Tem resultado → resolve
        if (isset($res_idx[$aposta['jogo_id']])) {
            $vencedor = $res_idx[$aposta['jogo_id']];
            $ganhou   = $aposta['escolha'] === $vencedor;
            $payout   = $ganhou ? floor($aposta['montante'] * $aposta['odd']) : 0;
            $aposta['estado']       = $ganhou ? 'ganha' : 'perdida';
            $aposta['ganhou']       = $ganhou;
            $aposta['payout']       = $payout;
            $aposta['resolvida_em'] = $agora;
            $aposta['notificado']   = false;
            if ($ganhou && $payout > 0) {
                $moedas = (int) get_user_meta($aposta['uid'], 'cbv_moedas', true);
                update_user_meta($aposta['uid'], 'cbv_moedas', $moedas + $payout);
            }
            continue;
        }

        // Sem resultado + passaram 48h → devolve moedas
        $ts_jogo = isset($aposta['ts_jogo']) ? $aposta['ts_jogo'] : 0;
        if ($ts_jogo > 0 && ($agora - $ts_jogo) > (48 * 3600)) {
            $aposta['estado']       = 'devolvida';
            $aposta['ganhou']       = null;
            $aposta['payout']       = $aposta['montante']; // devolve o que apostou
            $aposta['resolvida_em'] = $agora;
            $aposta['notificado']   = false;
            $moedas = (int) get_user_meta($aposta['uid'], 'cbv_moedas', true);
            update_user_meta($aposta['uid'], 'cbv_moedas', $moedas + $aposta['montante']);
        }
    }
    unset($aposta);
    cbv_ap_guardar_apostas($todas);
}

// Agenda cron se não estiver agendado
if (!wp_next_scheduled('cbv_apostas_cron')) {
    wp_schedule_event(time(), 'hourly', 'cbv_apostas_cron');
}

// ─── NOTIFICAÇÃO DE LOGIN ─────────────────────────────────────────────────────

// Quando o utilizador faz login, verifica apostas ganhas não notificadas
add_action('wp_login', 'cbv_ap_login_check', 10, 2);
function cbv_ap_login_check($user_login, $user) {
    $uid   = $user->ID;
    $todas = cbv_ap_get_todas_apostas();

    // Encontra apostas resolvidas não notificadas (ganhas + devolvidas)
    $resolvidas = array_filter($todas, function($a) use ($uid) {
        return $a['uid'] === $uid
            && in_array($a['estado'], ['ganha', 'devolvida'])
            && isset($a['notificado']) && $a['notificado'] === false;
    });

    if (empty($resolvidas)) return;

    $ganhas     = array_filter($resolvidas, fn($a) => $a['estado'] === 'ganha');
    $devolvidas = array_filter($resolvidas, fn($a) => $a['estado'] === 'devolvida');

    $total_ganho    = array_sum(array_column(array_values($ganhas), 'payout'));
    $total_devolvido = array_sum(array_column(array_values($devolvidas), 'montante'));
    $total_moedas   = $total_ganho + $total_devolvido;

    if ($total_moedas <= 0) return;

    $notif = [
        'total'      => $total_moedas,
        'num'        => count($ganhas),
        'devolvidas' => count($devolvidas),
        'ts'         => time(),
    ];
    update_user_meta($uid, 'cbv_apostas_notif', $notif);

    // Marca apostas como notificadas
    $todas_updated = array_map(function($a) use ($uid) {
        if ($a['uid'] === $uid && $a['estado'] === 'ganha' && empty($a['notificado'])) {
            $a['notificado'] = true;
        }
        return $a;
    }, $todas);
    cbv_ap_guardar_apostas($todas_updated);
}

// Endpoint REST para aceitar aviso (guarda em user_meta)
add_action('rest_api_init', function() {
    register_rest_route('cbv/v1', '/apostas/aceitar-aviso', [
        'methods'             => 'GET, POST',
        'permission_callback' => '__return_true',
        'callback'            => function($req) {
            if (!is_user_logged_in()) return rest_ensure_response(['aceite'=>false]);
            $uid = get_current_user_id();
            if ($req->get_method() === 'POST') {
                update_user_meta($uid, 'cbv_aviso_apostas', 1);
                return rest_ensure_response(['aceite'=>true]);
            }
            $aceite = (bool) get_user_meta($uid, 'cbv_aviso_apostas', true);
            return rest_ensure_response(['aceite'=>$aceite]);
        },
    ]);
});

// Endpoint REST para ler e limpar a notificação
add_action('rest_api_init', function() {
    register_rest_route('cbv/v1', '/apostas/notificacao', [
        'methods'             => 'GET',
        'permission_callback' => '__return_true',
        'callback'            => function() {
            if (!is_user_logged_in()) return rest_ensure_response(null);
            $uid   = get_current_user_id();
            $notif = get_user_meta($uid, 'cbv_apostas_notif', true);
            if (!$notif) return rest_ensure_response(null);
            // Apaga após ler — só mostra uma vez
            delete_user_meta($uid, 'cbv_apostas_notif');
            return rest_ensure_response($notif);
        },
    ]);
});
