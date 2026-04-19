# PROJECT BIBLE — CB Viana Digital
> Documento de contexto unificado para continuação por qualquer Claude.
> Última atualização: 2026-04-19
> ⚠️ SEMPRE atualizar este ficheiro no fim de cada sessão de trabalho.
> 🔗 Repositório: https://github.com/vianabasketball-maker/cbviana-digital

---

## INSTRUÇÃO PARA O PRÓXIMO CLAUDE

1. Lê a **Secção 13** para perceber o que está feito
2. Lê a **Secção 14** para perceber o próximo passo
3. Usa os raw URLs da **Secção 4** para ler o código real com `web_fetch`
4. Nunca recomeças do zero — continua de onde ficou
5. No fim da sessão, atualiza este ficheiro e faz upload para `docs/PROJECT_BIBLE.md` no GitHub

---

## 1. DESCRIÇÃO DO PROJETO

Site oficial do **Clube de Basquetebol de Viana do Castelo (CB Viana)** em **cbviana.com**.

Três pilares:

**A) Site WordPress institucional**
**B) Experiências interativas HTML standalone** — jogos, caderneta, raspadinha, apostas
**C) Sistema de gamificação** — moedas, highscores, apostas virtuais

---

## 2. IDENTIDADE VISUAL

```
Bordô:  #7B1C2E / #5a1220
Dourado: #F0A500
Fundo:  #060109 / #0a0410
Mascote: Fintas (raposa) 🦊
```

---

## 3. STACK TÉCNICA

WordPress + Basketball Club FSE v1.5.0 + Hostinger (u952199276)
Cloudinary: dmwwjylsw | Flickr: 136430889@N05
FPB Clube ID: 723 | Época: 2025/2026

---

## 4. RAW URLS

### APOSTAS
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/jogos/apostas.html
```

### JOGOS
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/jogos/basketman.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/jogos/chuva_bolas.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/jogos/jogos.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/jogos/lancamentos.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/jogos/memory.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/jogos/puzzle.html
```

### CADERNETA
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/caderneta/CadernetaViana.html
```

### PAGES-HTML
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/pages-html/raspadinha.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/pages-html/colecao.html
```

### WP-BLOCKS
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/ajuda.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/clube.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/contacto.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/galeria.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/timeout.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/equipas/equipas-hub.html
```

### WPCODE — PHP
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/CB%20Viana%20Menu
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/CBV%20Gamification%20System
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/cbv-apostas-wpcode
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/cbv-beta-access
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/cbv-admin-stats
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/cbv-ajuda-wpcode
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/cbv-raspadinha-php4
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/foto_puzzle
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/Inscri%C3%A7%C3%B5es
```

### WPCODE — HTML
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/html/cbv-gamification-header
```

### INSERT PHP
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/insertphp/jogos-fpb
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/insertphp/jogos-home
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/insertphp/horarios
```

### DOCS
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/docs/PROJECT_BIBLE.md
```

---

## 5. PÁGINAS WORDPRESS

| Página | Slug | Acesso |
|---|---|---|
| Home | /home | Público |
| Apostas | /apostas | Membros (UM Restrict) |
| TIMEOUT | /test | Público |
| Raspadinha | /raspadinha | Público |
| Ajuda-nos a Crescer | /ajuda-nos-a-crescer | Público |
| Competições | /desafios | Público |
| Contacto | /contacto | Público |
| Galeria | /galeria | Público |
| Equipas | /equipas | Público |
| Login | /login | Público |
| Account | /account | Membros |

---

## 6. SNIPPETS WPCODE

| Nome | Tipo | Função |
|---|---|---|
| CBV Gamification System | PHP | Moedas + scores + ajuda endpoint |
| CB Viana Menu | PHP | Menu v1.2 |
| cbv-apostas-wpcode | PHP | Sistema apostas completo + cron fix |
| cbv-beta-access | PHP | Role beta_tester + fix UM |
| cbv-admin-stats | PHP | Dashboard admin |
| cbv-ajuda-wpcode | PHP | Endpoint /cbv/v1/ajuda → email |
| cbv-raspadinha-php4 | PHP | Raspadinha |
| foto_puzzle | PHP | Fotos puzzle Cloudinary |
| cbv-gamification-header | HTML | UI moedas + CBVGam completo |

---

## 7. CBVGam — MÉTODOS

```javascript
CBVGam.addCoins(amount, callback)
CBVGam.payCoins(amount, callback)
CBVGam.canPay(amount)
CBVGam.getState() // {moedas, acessos, nivel, loggedIn, username, display_name}
CBVGam.saveScore(gameId, score, extra, callback)
CBVGam.getScores(callback)
CBVGam.cancelarAposta(apostaid, callback)
CBVGam.fazerAposta(jogoId, escolha, montante, callback)
CBVGam.getApostas(callback)
CBVGam.getJogosApostas(callback)

// Padrão acesso cross-iframe
function cbvGam(){
  return window.CBVGam ||
    (window.parent && window.parent.CBVGam) ||
    (window.parent && window.parent.parent && window.parent.parent.CBVGam) || null;
}
```

---

## 8. CBV APOSTAS

### Acesso
- Página `/apostas` restrita a membros via UM (Restrict Access)
- `$is_beta = true` no menu — apostas abertas a todos os membros
- Overlay apostas comentado — rollback: descomentar bloco `<?php /* ... */?>` no CB Viana Menu
- Aviso "jogo virtual" comentado no apostas.html — rollback: descomentar bloco AVISO

### Endpoints REST
```
GET  /cbv/v1/apostas/jogos       → jogos futuros com odds
GET  /cbv/v1/apostas/resultados  → jogos passados
GET  /cbv/v1/apostas/minhas      → apostas do utilizador
POST /cbv/v1/apostas/apostar     → colocar aposta (max 50 moedas)
POST /cbv/v1/apostas/cancelar    → cancelar aposta pendente
POST /cbv/v1/apostas/resolver    → resolver (admin)
GET  /cbv/v1/apostas/notificacao → notificação login
GET  /cbv/v1/apostas/refresh-info → timestamps FPB
```

### Odds
```
Viana GANHOU último → ×2.00 / ×1.75
Viana PERDEU último → ×4.00 / ×1.25
Sem histórico       → ×3.00 / ×1.50
Jogo sem Viana      → ×1.85 / ×1.85
```

### Filtro jogos (apostas.html)
- "Esta semana" = próximos 7 dias a partir de hoje
- Jogos já terminados (30min após início) não aparecem
- Se não há jogos nos próximos 7 dias → mostra semana seguinte automaticamente

---

## 9. CRON E CACHE FPB — ARQUITECTURA COMPLETA

### ⚠️ PROBLEMA RESOLVIDO — Documentado para futuras sessões

**Sintoma:** `refresh-info` mostrava sempre o mesmo timestamp (ex: 11:19) mesmo após horas.

**Causa raiz:** Dois problemas em conjunto:
1. O WP-Cron só corria quando havia visitas ao site — sem visitas, não disparava
2. A função `cbv_ap_cron_resolver()` não actualizava a cache FPB nem o `cbv_fpb_ultimo_refresh`

**Solução aplicada:**

**Fix 1 — Hostinger Cron Job** (`0 * * * *`):
```
/usr/bin/php /home/u952199276/domains/cbviana.com/public_html/wp-cron.php
```
Corre a cada hora em ponto, independentemente de visitas.

**Fix 2 — `cbv_ap_cron_resolver()`** no snippet `cbv-apostas-wpcode`:
Adicionado no início da função o código que faz fetch à FPB e actualiza o timestamp:
```php
$dir = ABSPATH . 'data/';
$urls = [
    $dir.'fpb_cal8.html' => 'https://www.fpb.pt/calendario/clube_723/...',
    $dir.'fpb_res8.html' => 'https://www.fpb.pt/resultados/clube_723/...',
];
$atualizado = false;
foreach($urls as $file => $url){
    if(!file_exists($file) || (time() - filemtime($file)) >= 3600){
        // curl fetch...
        if($res && strlen($res) > 5000){ file_put_contents($file,$res); $atualizado=true; }
    }
}
if($atualizado) update_option('cbv_fpb_ultimo_refresh', time());
```

**Fix 3 — Reagendar evento WordPress:**
Após qualquer alteração ao cron, reagendar via:
```
https://cbviana.com/?cbv_reschedule=1
```
(requer snippet temporário — ver abaixo)

### Fluxo completo após fix
```
Hostinger Cron Job (cada hora em ponto)
→ chama wp-cron.php
→ WordPress executa cbv_apostas_cron
→ cbv_ap_cron_resolver() corre:
   → faz fetch FPB (se cache > 1h)
   → actualiza fpb_cal8.html + fpb_res8.html
   → actualiza cbv_fpb_ultimo_refresh
   → resolve apostas pendentes
   → deteta jogos cancelados (+1🪙 bónus)
   → devolução automática após 48h
```

### Cache FPB
```
/public_html/data/fpb_cal8.html  → calendário (cache 1h)
/public_html/data/fpb_res8.html  → resultados (cache 1h)
wp_option: cbv_fpb_ultimo_refresh → timestamp último refresh
```

### ⚠️ Fuso horário
- WordPress configurado para `Europe/Lisbon`
- O `refresh-info` mostra hora UTC internamente — a GUI converte para hora local via `new Date(timestamp*1000)`
- Se `proximo_hora` no JSON mostrar hora errada → é o PHP a usar `date()` em vez de `wp_date()` — fix pendente

### Snippet temporário para emergências
Se o cron parar de funcionar, criar snippet WPCode temporário:
```php
add_action('init', function(){
  if(isset($_GET['cbv_force_refresh']) && current_user_can('administrator')){
    cbv_ap_cron_resolver();
    die('Refresh feito: '.date('H:i:s'));
  }
  if(isset($_GET['cbv_reschedule']) && current_user_can('administrator')){
    wp_clear_scheduled_hook('cbv_apostas_cron');
    wp_schedule_event(time(), 'hourly', 'cbv_apostas_cron');
    die('Reagendado! Próximo: '.date('H:i:s', wp_next_scheduled('cbv_apostas_cron')));
  }
});
```
URLs de uso:
- `https://cbviana.com/?cbv_force_refresh=1` — força refresh imediato
- `https://cbviana.com/?cbv_reschedule=1` — reagenda o evento
- Apagar o snippet depois de usar!

---

## 10. HIGHSCORES GLOBAIS

```
GET  /wp-json/cbv/v1/scores → top 3 por jogo
POST /wp-json/cbv/v1/scores → guarda score
```

Fluxo: jogo → postMessage → jogos.html → WordPress (cbv-gamification-header) → API

---

## 11. MENU — CB Viana Menu v1.2

```php
// Estrutura array $nav
[label, url, special, caderneta, beta, submenu[], classe_extra]

// Controlo apostas
$is_beta = true;  // mudar para false para fechar

// Itens especiais
'caderneta'    → dourado pulsante (overlay "Em Breve" para não-admins)
'special'      → dourado sólido (TIMEOUT)
'apostas-beta' → azul com ribbon BETA
'ajuda'        → verde transparente rgba(26,92,58,0.5)
```

---

## 12. AJUDA-NOS A CRESCER

- URL: `/ajuda-nos-a-crescer`
- wp-blocks/ajuda.html — hero com Fintas + logo CBV
- ⚠️ Substituir no HTML: `URL_FOTO_FINTAS_AQUI` e `URL_LOGO_CBV_AQUI`
- Endpoint: POST `/cbv/v1/ajuda` → email vianabasketball@gmail.com
- Menu: após Contacto, estilo verde discreto

---

## 13. ESTADO ATUAL

| Feature | Estado |
|---|---|
| Site WordPress completo | ✅ |
| Menu v1.2 com Ajuda-nos a Crescer | ✅ |
| CBV Apostas — aberto a membros | ✅ |
| Highscores globais todos os jogos | ✅ |
| Raspadinha múltipla fix | ✅ |
| Página Ajuda-nos a Crescer | ✅ (faltam imagens Fintas + logo) |
| Cron FPB automático (Hostinger + WP) | ✅ |
| Filtro jogos — próximos 7 dias + fallback semana seguinte | ✅ |
| Fuso horário WordPress → Europe/Lisbon | ✅ |
| Fuso horário refresh-info GUI | ⚠️ mostra UTC — fix pendente |
| Post Facebook apostas + ajuda | ⏳ vídeo Fintas em preparação |
| Imagens Fintas + logo na página ajuda | ⏳ |
| Persistência server-side caderneta | ⏳ |
| Loja de pacotes (100 moedas) | ⏳ |
| Mercado de trocas | ⏳ |
| Página Junta-te a Nós | ⏳ aguarda Carlos |
| Horários actualizados | ⏳ aguarda Carlos |

---

## 14. PRÓXIMOS PASSOS

### 🟡 Imediato
1. **Fix fuso horário refresh-info** — PHP usar `wp_date()` em vez de `date()` no endpoint `refresh-info`
2. **Post Facebook** — vídeo Fintas + texto preparado
3. **Imagens Fintas + logo** — substituir placeholders em wp-blocks/ajuda.html

### 🟢 Futuro
4. Persistência server-side caderneta
5. Loja de pacotes (100 moedas → 4 cromos)
6. Mercado de trocas
7. Página histórica (aguarda Carlos)

---

## 15. DECISÕES TÉCNICAS

| Decisão | Motivo |
|---|---|
| Hostinger Cron Job para WP-Cron | WP-Cron não dispara sem visitas |
| cbv_ap_cron_resolver() faz fetch FPB | Garante cache actualizada mesmo sem visitas |
| UM restringe /apostas | Mais limpo que beta-wall manual |
| $is_beta = true | Apostas abertas — false para fechar |
| Aviso comentado | Rollback fácil |
| Filtro 7 dias + fallback | Nunca mostra "Sem jogos" se há jogos futuros |
| CBVGam via window.parent chain | Cookies não passam em iframes |

---

## 16. EQUIPA

| Pessoa | Papel |
|---|---|
| Alex | Gestor digital voluntário |
| Alessandro | Co-gestor |
| Carlos | Conteúdos |
| Fintas | Mascote oficial 🦊 |

### Hostinger
```
/public_html/jogos/        ← jogos + apostas.html
/public_html/data/         ← cache FPB (fpb_cal8.html, fpb_res8.html)
/public_html/Caderneta/    ← caderneta + assets
/public_html/data_apostas/ ← ap_logomap.json
```

### Hostinger Cron Jobs activos
```
0 * * * * → /usr/bin/php /home/u952199276/domains/cbviana.com/public_html/wp-cron.php
```
