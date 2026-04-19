// CBV APOSTAS — v1.0
// WPCode PHP snippet — adicionar como novo snippet em WPCode > PHP Snippets

// ─── CONSTANTES ───────────────────────────────────────────────────────────────
if ( ! defined('CBV_AP_CLUBE_ID') ) {
    define('CBV_AP_CLUBE_ID',   '723');
    define('CBV_AP_VIANA_PAT',  'VIA');
    define('CBV_AP_EPOCA',      '2025/2026');
    define('CBV_AP_MAX_APOSTA', 50);   // Limite aumentado para 50 moedas
    define('CBV_AP_BETS_KEY',   'cbv_apostas_v1');
    define('CBV_AP_DATA_DIR',   ABSPATH . 'data/');         // Partilhado com site
    define('CBV_AP_CAL_FILE',   ABSPATH . 'data/fpb_cal8.html');
    define('CBV_AP_RES_FILE',   ABSPATH . 'data/fpb_res8.html');
    define('CBV_AP_LOGOMAP',    ABSPATH . 'data_apostas/ap_logomap.json');
}

// ─── HOOK: SNIPPET SITE AVISA APOSTAS ────────────────────────────────────────
// O snippet jogos-fpb chama: do_action('cbv_fpb_atualizado') após atualizar ficheiros
// As apostas subscrevem e resolvem pendentes automaticamente
add_action('cbv_fpb_atualizado', function() {
    // Guarda timestamp do último refresh
    update_option('cbv_fpb_ultimo_refresh', time());
    // Dispara resolução de apostas pendentes
    cbv_ap_cron_resolver();
});

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
    $map_file = CBV_AP_LOGOMAP;
    if (file_exists($map_file) && (time() - filemtime($map_file)) < 86400) {
        $d = json_decode(file_get_contents($map_file), true);
        if ($d) return $d;
    }
    $html = cbv_ap_get_html_res(); // usa ficheiro local do site
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
// ─── LER FICHEIROS DO SITE (sem fetch próprio) ───────────────────────────────
// As apostas reutilizam os ficheiros já produzidos pelo snippet jogos-fpb
// Timestamp do último refresh disponível em wp_options cbv_fpb_ultimo_refresh
function cbv_ap_get_html_cal() {
    return file_exists(CBV_AP_CAL_FILE) ? file_get_contents(CBV_AP_CAL_FILE) : '';
}
function cbv_ap_get_html_res() {
    return file_exists(CBV_AP_RES_FILE) ? file_get_contents(CBV_AP_RES_FILE) : '';
}
function cbv_ap_proximo_refresh() {
    $ultimo = (int) get_option('cbv_fpb_ultimo_refresh', 0);
    if (!$ultimo) {
        // Se não há registo, usa o filemtime do ficheiro
        $ultimo = file_exists(CBV_AP_RES_FILE) ? filemtime(CBV_AP_RES_FILE) : time();
    }
    return $ultimo + 3600; // próximo refresh em 1 hora
}


function cbv_ap_get_stats_cached() { return []; } // odds agora baseadas no último jogo

// ─── CALCULAR ODDS ────────────────────────────────────────────────────────────
// Lógica baseada no último jogo desta época entre o CB Viana e o adversário:
//   Viana GANHOU o último jogo → Viana ×2.00 / Adversário ×1.75
//   Viana PERDEU o último jogo → Viana ×4.00 / Adversário ×1.25 (azarão — máxima emoção!)
//   Sem histórico entre os dois → Viana ×3.00 / Adversário ×1.50 (base)
//   Jogo sem CB Viana → ×1.85 / ×1.85 (neutro)
function cbv_ap_calcular_odds_jogo($sigla_casa, $sigla_fora, $jogos_epoca) {
    $id_viana = CBV_AP_CLUBE_ID;
    $pat      = CBV_AP_VIANA_PAT;

    $e_viana_casa = stripos($sigla_casa, $pat) !== false || stripos($sigla_casa, 'viana') !== false;
    $e_viana_fora = stripos($sigla_fora, $pat) !== false || stripos($sigla_fora, 'viana') !== false;

    // Jogo sem CB Viana → odds neutras
    if (!$e_viana_casa && !$e_viana_fora) {
        return [
            'odd_casa' => 1.85, 'odd_fora' => 1.85,
            'pct_casa' => 50,   'pct_fora' => 50,
            'contexto' => 'neutro',
        ];
    }

    // Procura último jogo entre estes dois esta época
    $ultimo = null;
    foreach (array_reverse($jogos_epoca) as $j) {
        if (!$j['tem_resultado']) continue;
        $match_casa = stripos($j['sigla_casa'], $pat) !== false || stripos($j['sigla_casa'], 'viana') !== false;
        $match_fora = stripos($j['sigla_fora'], $pat) !== false || stripos($j['sigla_fora'], 'viana') !== false;
        // Verifica se é o mesmo adversário
        $adv_casa = $e_viana_casa ? $sigla_fora : $sigla_casa;
        $e_mesmo  = stripos($j['sigla_casa'], substr($adv_casa, 0, 6)) !== false
                 || stripos($j['sigla_fora'], substr($adv_casa, 0, 6)) !== false;
        if (($match_casa || $match_fora) && $e_mesmo) {
            $ultimo = $j;
            break;
        }
    }

    // Determina se Viana ganhou ou perdeu
    if ($ultimo) {
        $viana_era_casa = stripos($ultimo['sigla_casa'], $pat) !== false || stripos($ultimo['sigla_casa'], 'viana') !== false;
        $viana_ganhou   = ($viana_era_casa && $ultimo['vencedor'] === 'casa')
                       || (!$viana_era_casa && $ultimo['vencedor'] === 'fora');

        if ($viana_ganhou) {
            // Viana favorito — odds moderadas
            return [
                'odd_casa' => $e_viana_casa ? 2.00 : 1.75,
                'odd_fora' => $e_viana_casa ? 1.75 : 2.00,
                'pct_casa' => $e_viana_casa ? 60   : 40,
                'pct_fora' => $e_viana_casa ? 40   : 60,
                'contexto' => 'favorito',
            ];
        } else {
            // Viana azarão — odds máximas (mais emoção!)
            return [
                'odd_casa' => $e_viana_casa ? 4.00 : 1.25,
                'odd_fora' => $e_viana_casa ? 1.25 : 4.00,
                'pct_casa' => $e_viana_casa ? 25   : 75,
                'pct_fora' => $e_viana_casa ? 75   : 25,
                'contexto' => 'azarao',
            ];
        }
    }

    // Sem histórico — odds base
    return [
        'odd_casa' => $e_viana_casa ? 3.00 : 1.50,
        'odd_fora' => $e_viana_casa ? 1.50 : 3.00,
        'pct_casa' => $e_viana_casa ? 40   : 60,
        'pct_fora' => $e_viana_casa ? 60   : 40,
        'contexto' => 'base',
    ];
}

// Compatibilidade — wrapper antigo
function cbv_ap_calcular_odds($wr_casa, $wr_fora) {
    return ['odd_casa'=>1.85,'odd_fora'=>1.85,'pct_casa'=>50,'pct_fora'=>50];
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
            $html = cbv_ap_get_html_cal(); // ficheiro local do site
            $jogos    = cbv_ap_parse_fpb($html);
            $logo_map = cbv_ap_logo_map();
            $hoje     = strtotime(date('Y-m-d'));

            // Resultados desta época — lê ficheiro já produzido pelo site
            $jogos_epoca = cbv_ap_parse_fpb(cbv_ap_get_html_res());

            $resultado = [];

            foreach ($jogos as $j) {
                if (!$j['ts'] || $j['ts'] < $hoje) continue;
                if ($j['tem_resultado']) continue;

                $logo_fb   = 'https://sav2.fpb.pt/old_uploads/CLU/CLU_'.CBV_AP_CLUBE_ID.'_LOGO.jpg';
                $logo_casa = cbv_ap_get_logo($j['sigla_casa'], $logo_map, $j['logo_casa'] ?: $logo_fb);
                $logo_fora = cbv_ap_get_logo($j['sigla_fora'], $logo_map, $j['logo_fora'] ?: $logo_fb);

                // Odds baseadas no último jogo desta época
                $odds = cbv_ap_calcular_odds_jogo($j['sigla_casa'], $j['sigla_fora'], $jogos_epoca);

                $resultado[] = [
                    'id'         => md5($j['link']),
                    'link'       => $j['link'],
                    'ts'         => $j['ts'],
                    'data'       => $j['data'],
                    'hora'       => $j['hora'],
                    'comp'       => $j['comp'],
                    'sigla_casa' => $j['sigla_casa'],
                    'sigla_fora' => $j['sigla_fora'],
                    'id_casa'    => $j['id_casa'],
                    'id_fora'    => $j['id_fora'],
                    'logo_casa'  => $logo_casa,
                    'logo_fora'  => $logo_fora,
                    'odd_casa'   => $odds['odd_casa'],
                    'odd_fora'   => $odds['odd_fora'],
                    'pct_casa'   => $odds['pct_casa'],
                    'pct_fora'   => $odds['pct_fora'],
                    'contexto'   => $odds['contexto'], // favorito / azarao / base / neutro
                ];
            }

            usort($resultado, fn($a,$b) => $a['ts'] - $b['ts']);
            return rest_ensure_response($resultado);
        },
    ]);

    // GET /cbv/v1/apostas/resultados — jogos passados com resultado
    register_rest_route('cbv/v1', '/apostas/resultados', [
        'methods'             => 'GET',
        'permission_callback' => '__return_true',
        'callback'            => function() {
            $html  = cbv_ap_get_html_res();
            $jogos = cbv_ap_parse_fpb($html);
            $logo_map = cbv_ap_logo_map();
            $logo_fb  = 'https://sav2.fpb.pt/old_uploads/CLU/CLU_'.CBV_AP_CLUBE_ID.'_LOGO.jpg';
            $resultado = [];

            foreach ($jogos as $j) {
                if (!$j['tem_resultado']) continue;
                $logo_casa = cbv_ap_get_logo($j['sigla_casa'], $logo_map, $j['logo_casa'] ?: $logo_fb);
                $logo_fora = cbv_ap_get_logo($j['sigla_fora'], $logo_map, $j['logo_fora'] ?: $logo_fb);
                $wr_casa   = isset($stats[$j['id_casa']]) ? $stats[$j['id_casa']]['winRate'] : 0.50;
                $wr_fora   = isset($stats[$j['id_fora']]) ? $stats[$j['id_fora']]['winRate'] : 0.50;
                $odds      = cbv_ap_calcular_odds($wr_casa, $wr_fora);
                $resultado[] = [
                    'id'         => md5($j['link']),
                    'ts'         => $j['ts'],
                    'data'       => $j['data'],
                    'hora'       => $j['hora'],
                    'comp'       => $j['comp'],
                    'sigla_casa' => $j['sigla_casa'],
                    'sigla_fora' => $j['sigla_fora'],
                    'logo_casa'  => $logo_casa,
                    'logo_fora'  => $logo_fora,
                    'odd_casa'   => $odds['odd_casa'],
                    'odd_fora'   => $odds['odd_fora'],
                    'pct_casa'   => $odds['pct_casa'],
                    'pct_fora'   => $odds['pct_fora'],
                    'tem_resultado' => true,
                    'score_casa' => $j['score_casa'],
                    'score_fora' => $j['score_fora'],
                    'vencedor'   => $j['vencedor'],
                ];
            }
            usort($resultado, fn($a,$b) => $b['ts'] - $a['ts']);
            return rest_ensure_response($resultado);
        },
    ]);

    // POST /cbv/v1/apostas/enriquecer — atualiza apostas sem dados com info dos jogos FPB
    register_rest_route('cbv/v1', '/apostas/enriquecer', [
        'methods'             => 'POST',
        'permission_callback' => function(){ return current_user_can('manage_options'); },
        'callback'            => function() {
            $todas    = cbv_ap_get_todas_apostas();
            $logo_map = cbv_ap_logo_map();
            $logo_fb  = 'https://sav2.fpb.pt/old_uploads/CLU/CLU_'.CBV_AP_CLUBE_ID.'_LOGO.jpg';

            // Carrega todos os jogos (cal + res)
            $jogos_cal = cbv_ap_parse_fpb(cbv_ap_get_html_cal());
            $jogos_res = cbv_ap_parse_fpb(cbv_ap_get_html_res());
            $todos_jogos = array_merge($jogos_cal, $jogos_res);

            // Indexa por jogo_id
            $idx = [];
            foreach ($todos_jogos as $j) {
                $idx[md5($j['link'])] = $j;
            }

            $atualizadas = 0;
            foreach ($todas as &$aposta) {
                // Só enriquece apostas sem siglas
                if (!empty($aposta['sigla_casa']) && !empty($aposta['sigla_fora'])) continue;
                if (!isset($idx[$aposta['jogo_id']])) continue;

                $j = $idx[$aposta['jogo_id']];
                $aposta['sigla_casa'] = $j['sigla_casa'] ?? $j['ec'] ?? '';
                $aposta['sigla_fora'] = $j['sigla_fora'] ?? $j['ef'] ?? '';
                $aposta['logo_casa']  = cbv_ap_get_logo($aposta['sigla_casa'], $logo_map, $j['logo_casa'] ?? $j['lc'] ?? $logo_fb);
                $aposta['logo_fora']  = cbv_ap_get_logo($aposta['sigla_fora'], $logo_map, $j['logo_fora'] ?? $j['lf'] ?? $logo_fb);
                $aposta['comp']       = $j['comp'] ?? '';
                $aposta['data']       = $j['data'] ?? '';
                $aposta['hora']       = $j['hora'] ?? '';
                $atualizadas++;
            }
            unset($aposta);

            if ($atualizadas > 0) cbv_ap_guardar_apostas($todas);

            return rest_ensure_response([
                'sucesso'     => true,
                'atualizadas' => $atualizadas,
                'total'       => count($todas),
            ]);
        },
    ]);

    // GET /cbv/v1/apostas/refresh-info — quando foi o último refresh e quando será o próximo
    register_rest_route('cbv/v1', '/apostas/refresh-info', [
        'methods'             => 'GET',
        'permission_callback' => '__return_true',
        'callback'            => function() {
            $ultimo   = (int) get_option('cbv_fpb_ultimo_refresh', 0);
            if (!$ultimo && file_exists(CBV_AP_RES_FILE)) {
                $ultimo = filemtime(CBV_AP_RES_FILE);
            }
            $proximo  = $ultimo ? $ultimo + 3600 : time() + 3600;
            return rest_ensure_response([
                'ultimo_refresh'  => $ultimo,
                'proximo_refresh' => $proximo,
                'proximo_hora'    => $proximo ? date('H:i', $proximo) : '--:--',
            ]);
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
                $a_cancelada  = $a; // guarda para resposta
                break;
            }
            unset($a);
            if (!$found) return new WP_Error('not_found', 'Aposta não encontrada', ['status'=>404]);
            cbv_ap_guardar_apostas($todas);
            return rest_ensure_response([
                'sucesso'           => true,
                'moedas'            => $moedas_novas,
                'moedas_devolvidas' => $a_cancelada['montante'] ?? 0,
                'saldo_anterior'    => $moedas,
                'saldo_atual'       => $moedas_novas,
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
            // Lê ficheiro de calendário já produzido pelo snippet do site
            $html = cbv_ap_get_html_cal();
            $jogos = cbv_ap_parse_fpb($html);
            foreach ($jogos as $j) {
                if (md5($j['link']) === $jogo_id) {
                    $odds_j  = cbv_ap_calcular_odds_jogo($j['sigla_casa'], $j['sigla_fora'], cbv_ap_parse_fpb(cbv_ap_get_html_res()));
                    $odd     = $escolha === 'casa' ? $odds_j['odd_casa'] : $odds_j['odd_fora'];
                    break;
                }
            }

            // Guardar aposta
            // Encontra timestamp do jogo para lógica de devolução (48h sem resultado)
            $ts_jogo = 0;
            foreach ($jogos as $jg) {
                if (md5($jg['link']) === $jogo_id) { $ts_jogo = $jg['ts'] ?: 0; break; }
            }

            // Dados do jogo para mostrar no histórico mesmo depois do jogo terminar
            $jogo_data = [];
            $logo_map  = cbv_ap_logo_map();
            $logo_fb   = 'https://sav2.fpb.pt/old_uploads/CLU/CLU_'.CBV_AP_CLUBE_ID.'_LOGO.jpg';
            foreach ($jogos as $jg) {
                if (md5($jg['link']) === $jogo_id) {
                    $jogo_data = [
                        'sigla_casa' => $jg['sigla_casa'],
                        'sigla_fora' => $jg['sigla_fora'],
                        'logo_casa'  => cbv_ap_get_logo($jg['sigla_casa'], $logo_map, $jg['logo_casa'] ?: $logo_fb),
                        'logo_fora'  => cbv_ap_get_logo($jg['sigla_fora'], $logo_map, $jg['logo_fora'] ?: $logo_fb),
                        'comp'       => $jg['comp'],
                        'data'       => $jg['data'],
                        'hora'       => $jg['hora'],
                        'pct_casa'   => 0,
                        'pct_fora'   => 0,
                        'odd_casa'   => 0,
                        'odd_fora'   => 0,
                    ];
                    // Odds
                    $wr_c = isset($stats[$jg['id_casa']]) ? $stats[$jg['id_casa']]['winRate'] : 0.5;
                    $wr_f = isset($stats[$jg['id_fora']]) ? $stats[$jg['id_fora']]['winRate'] : 0.5;
                    $o    = cbv_ap_calcular_odds($wr_c, $wr_f);
                    $jogo_data['pct_casa']  = $o['pct_casa'];
                    $jogo_data['pct_fora']  = $o['pct_fora'];
                    $jogo_data['odd_casa']  = $o['odd_casa'];
                    $jogo_data['odd_fora']  = $o['odd_fora'];
                    break;
                }
            }

            $aposta = array_merge([
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
            ], $jogo_data);
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
            // Lê ficheiro local do site
            $res_html = cbv_ap_get_html_res();
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
            // Stats já não existem — odds baseadas no último jogo
            return rest_ensure_response([
                'sucesso' => true,
                'mensagem' => 'Stats removidas — odds calculadas por histórico desta época',
            ]);
        },
    ]);

});


// ─── CRON AUTOMÁTICO — resolve apostas diariamente ───────────────────────────
add_action('cbv_apostas_cron', 'cbv_ap_cron_resolver');
function cbv_ap_cron_resolver() {
    $dir = ABSPATH . 'data/';
    if(!file_exists($dir)) mkdir($dir, 0755, true);

    // ── NOVO: Força actualização da cache FPB + timestamp ──
    $urls = [
        $dir.'fpb_cal8.html' => 'https://www.fpb.pt/calendario/clube_723/?clube=723&epoca=2025/2026',
        $dir.'fpb_res8.html' => 'https://www.fpb.pt/resultados/clube_723/?clube=723&epoca=2025/2026',
    ];
    $atualizado = false;
    foreach($urls as $file => $url){
        if(!file_exists($file) || (time() - filemtime($file)) >= 3600){
            $ch = curl_init();
            curl_setopt_array($ch,[
                CURLOPT_URL            => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 20,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_ENCODING       => '',
                CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            ]);
            $res = curl_exec($ch); curl_close($ch);
            if($res && strlen($res) > 5000){ file_put_contents($file, $res); $atualizado = true; }
        }
    }
    update_option('cbv_fpb_ultimo_refresh', time());

    // ── Lê ficheiro local já produzido pelo snippet do site ──
    $res_html = cbv_ap_get_html_res();
    $resultados = cbv_ap_parse_fpb($res_html);
    $res_idx = [];
    foreach ($resultados as $r) {
        if ($r['tem_resultado'] && $r['vencedor']) {
            $res_idx[md5($r['link'])] = $r['vencedor'];
        }
    }
    $todas = cbv_ap_get_todas_apostas();
    $cal_html  = cbv_ap_get_html_cal();
    $jogos_cal = cbv_ap_parse_fpb($cal_html);
    $logo_map = cbv_ap_logo_map();
    $logo_fb  = 'https://sav2.fpb.pt/old_uploads/CLU/CLU_'.CBV_AP_CLUBE_ID.'_LOGO.jpg';

    // Índice de todos os jogos conhecidos (cal + res) para detetar cancelamentos
    $todos_jogos_idx = [];
    foreach ($jogos_cal as $j)  $todos_jogos_idx[md5($j['link'])] = true;
    foreach ($resultados as $j) $todos_jogos_idx[md5($j['link'])] = true;

    $agora = time();
    foreach ($todas as &$aposta) {
        if ($aposta['estado'] !== 'pendente') continue;

        // Jogo desapareceu dos dados FPB após 24h → provavelmente cancelado
        $ts_jogo = $aposta['ts_jogo'] ?? 0;
        if ($ts_jogo > 0
            && ($agora - $ts_jogo) > 86400
            && !isset($todos_jogos_idx[$aposta['jogo_id']])
            && $aposta['estado'] === 'pendente'
        ) {
            $uid = $aposta['uid'];
            $reembolso = $aposta['montante'] + 1;
            $moedas_atuais = (int) get_user_meta($uid, 'cbv_moedas', true);
            update_user_meta($uid, 'cbv_moedas', $moedas_atuais + $reembolso);
            $aposta['estado']       = 'devolvida';
            $aposta['ganhou']       = null;
            $aposta['payout']       = $reembolso;
            $aposta['resolvida_em'] = $agora;
            $aposta['motivo']       = 'jogo_cancelado';
            $aposta['notificado']   = false;
            continue;
        }

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
            $aposta['payout']       = $aposta['montante'];
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
