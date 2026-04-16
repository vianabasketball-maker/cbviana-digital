# PROJECT BIBLE — CB Viana Digital
> Documento de contexto unificado para continuação por qualquer Claude.
> Última atualização: Abril 2026 — Sessão: Highscores Globais
> 🔗 Repositório: https://github.com/vianabasketball-maker/cbviana-digital

---

## ⚡ PROTOCOLO OBRIGATÓRIO — LÊ ISTO PRIMEIRO

### 🟢 INÍCIO DE CADA SESSÃO — O Claude faz isto automaticamente:
1. Lê este BIBLE completo com `web_fetch`
2. Confirma: *"Li o PROJECT_BIBLE. Estado actual: [resumo]. Próximo passo: [passo 1 da Secção 10]."*
3. Pergunta: *"O que queres trabalhar hoje?"*
4. Antes de alterar qualquer ficheiro, lê o código actual do GitHub com `web_fetch`

### 🔴 FIM DE CADA SESSÃO — O Claude faz isto automaticamente:
1. Gera o BIBLE actualizado com tudo o que foi feito
2. Lista os ficheiros alterados que precisam de update no GitHub
3. Avisa: *"Sessão terminada. Faz o upload do BIBLE e dos ficheiros alterados para o GitHub."*

### ⚠️ REGRA DE OURO
**Nunca termines uma sessão sem fazer upload do BIBLE actualizado + ficheiros alterados para o GitHub.**

### 📋 PROMPT PARA INICIAR QUALQUER SESSÃO NOVA
```
Lê o PROJECT BIBLE do projecto CB Viana e confirma o estado actual:
web_fetch("https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/docs/PROJECT_BIBLE.md")
```

---

## 1. DESCRIÇÃO DO PROJETO

Site oficial do **Clube de Basquetebol de Viana do Castelo (CB Viana)** em **cbviana.com**.

Três pilares:

**A) Site WordPress institucional** — site público com informação do clube, jogos/resultados FPB, galeria, área de membros, blog, contactos, inscrições.

**B) Experiências interativas (HTML standalone)** — ficheiros HTML auto-contidos embutidos via iframe no WordPress:
- Caderneta digital de cromos (álbum + abertura de packs + drag-and-drop)
- Jogos: BasketMan, Chuva de Bolas, Puzzle, Lançamentos, Memory
- Raspadinha diária
- Sistema de moedas (CBVGam)

**C) Sistema de gamificação com persistência** — backend WordPress:
- Moedas por utilizador (✅ em produção)
- Highscores globais por jogo (✅ em produção)
- Coleção de cromos por utilizador (⏳)
- Mercado de trocas (⏳)

---

## 2. IDENTIDADE VISUAL

```
Bordô:        #7B1C2E  /  #6B1428  /  #5a1220
Dourado:      #F0A500  /  #FFB800
Fundo escuro: #060109  /  #0f0f1a  /  #0a0410  /  #1a0a08
```

---

## 3. STACK TÉCNICA

### WordPress (cbviana.com — Hostinger)
| Componente | Detalhe |
|---|---|
| CMS | WordPress |
| Tema | Basketball Club v1.5.0 (WP Radiant) — FSE |
| Hosting | Hostinger — user: u952199276 |
| Email | vianabasketball@gmail.com |

### Plugins activos
| Plugin | Versão | Função |
|---|---|---|
| Ultimate Member | 2.11.3 | Membros, login, perfil, account |
| Nextend Social Login | 3.1.23 | Login com Google |
| Complianz | 7.4.5 | RGPD / cookies |
| WPForms Lite | 1.10.0.4 | Formulário contactos (ID: 340) |
| WP Mail SMTP | 4.7.1 | Email via Gmail |
| Insert PHP Code Snippet | 1.4.5 | Shortcodes PHP personalizados |
| WPCode Lite | 2.3.5 | Injeção de código |
| Photonic Gallery | 3.31 | Galeria Flickr |
| Rank Math SEO | 1.0.268 | SEO (modo Advanced) |
| Advanced Custom Fields | 6.8.0 | Campos personalizados |
| Wordfence Security | 8.1.4 | Segurança |
| WP File Manager | 8.0.3 | Gestão de ficheiros |
| WP Statistics | 14.16.5 | Estatísticas de visitas |
| Shortcodes Ultimate | 7.5.0 | Shortcodes visuais |
| All-in-One WP Migration | 7.105 | Backups |
| Hostinger Tools | 3.0.65 | Ferramentas Hostinger |

### Serviços externos
| Serviço | Detalhe |
|---|---|
| Cloudinary | Cloud: `dmwwjylsw` |
| Flickr | User ID: `136430889@N05`, API Key: `615d446b553f45a1a89ea5214aab2a09` |
| Google | vianabasketball@gmail.com |
| GitHub | https://github.com/vianabasketball-maker/cbviana-digital (público) |

### FPB
```
Clube ID: 723  |  Época: 2025/2026
Cache: /public_html/data/fpb_cal8.html e fpb_res8.html (gerados a cada 6h)
```

---

## 4. RAW URLS — REPOSITÓRIO COMPLETO

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
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/caderneta/colecao.html
```

### PAGES-HTML
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/pages-html/cbv-mascote-animacao.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/pages-html/colecao.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/pages-html/em_construcao.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/pages-html/formacao.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/pages-html/raspadinha.html
```

### WP-BLOCKS
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/clube.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/contacto.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/galeria.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/instalacoes.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/pais-clube.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/staff.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/timeout.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/equipas/equipas-hub.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/equipas/mini10.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/equipas/mini12.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/equipas/senior.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/equipas/sub14.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/equipas/sub16.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wp-blocks/equipas/sub18.html
```

### WPCODE — PHP
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/BlocoDevMode
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/CB%20Viana%20Menu
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/CBV%20Admin
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/CBV%20Gamification%20System
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/Inscri%C3%A7%C3%B5es
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/cbv-raspadinha-php4
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/foto_puzzle
```

### WPCODE — HTML
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/html/Explica%C3%A7%C3%A3o
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/html/Pop-up%20Registration
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/html/cbv-gamification-header
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/html/notifica%C3%A7%C3%A3o_raspadinha
```

### WPCODE — JS
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/JS/UnderContrunctionPage
```

### INSERT PHP
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/insertphp/avatar
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/insertphp/horarios
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/insertphp/jogos-fpb
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/insertphp/jogos-home
```

### DATA + DOCS
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/data/horarios.csv
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/docs/PROJECT_BIBLE.md
```

---

## 5. PÁGINAS WORDPRESS

| Página | Slug | Conteúdo |
|---|---|---|
| Home | /home | `[xyz-ips snippet="jogos-home"]` |
| Competições | /desafios | `[xyz-ips snippet="jogos-fpb"]` + Gutenberg |
| Horários | /horarios | `[xyz-ips snippet="horarios"]` |
| Junta-te a Nós | /junta-te-a-nos | `[cbv_inscricoes]` (wpcode #625) |
| Coleção | /colecao | `<iframe src="/colecao.html">` |
| Caderneta | /caderneta | iframe CadernetaViana.html (admin only via WPCode) |
| Raspadinha | /raspadinha | wp-blocks/raspadinha |
| Galeria | /galeria | wp-blocks/galeria.html |
| Clube | /clube | wp-blocks/clube.html |
| Contacto | /contacto | wp-blocks/contacto.html |
| Staff | /staff | wp-blocks/staff.html |
| Instalações | /instalacoes | wp-blocks/instalacoes.html |
| Pais & Clube | /pais-clube | wp-blocks/pais-clube.html |
| TIMEOUT | /test | iframe jogos.html |
| Equipas | /equipas | Gutenberg + wp-blocks/equipas/ |

---

## 6. SNIPPETS

### WPCode
| ID | Nome | Tipo | Função | Versão |
|---|---|---|---|---|
| 601 | CBV Gamification System | PHP | Moedas + endpoints REST scores | v1.1 |
| 605 | CBV Admin | PHP | Painel admin gamificação | — |
| 624 | CB Viana Menu | PHP | Menu + Caderneta overlay + iframe admin | v1.1 |
| 625 | Inscrições | PHP | Shortcode `[cbv_inscricoes]` | — |
| 642 | BlocoDevMode | PHP | Proteção DevTools/F12 | — |
| 593 | foto_puzzle | PHP | Fotos Puzzle via Cloudinary | — |
| 596 | cbv-raspadinha-php4 | PHP | Lógica PHP da raspadinha | — |
| 597 | cbv-gamification-header | HTML | UI moedas + saveScore + getScores | v1.1 |
| 600 | notificação_raspadinha | HTML | Notificação footer raspadinha | — |
| 616 | Explicação | HTML | Tutorial/explicação | — |
| 525 | Pop-up Registration | HTML | Pop-up de registo | — |
| 237 | UnderConstructionPage | JS | Página em construção | — |

### Insert PHP
| Shortcode | Função |
|---|---|
| `[xyz-ips snippet="avatar"]` | Avatar no header |
| `[xyz-ips snippet="jogos-home"]` | Próximos jogos na Home |
| `[xyz-ips snippet="jogos-fpb"]` | Calendário + resultados FPB |
| `[xyz-ips snippet="horarios"]` | Tabela horários treinos |

---

## 7. ARQUITETURA HIGHSCORES GLOBAIS

### Fluxo completo
```
jogo.html (ex: puzzle)
  → postMessage(cbv_score) → window.parent (jogos.html)
  
jogos.html
  → postMessage(cbv_score) → window.parent (WordPress)
  
WordPress (cbv-gamification-header)
  → CBVGam.saveScore() → POST /wp-json/cbv/v1/scores
  → postMessage(cbv_score_saved) → jogos.html
  
jogos.html
  → showNotif("🏆 Alex — 1250 pts · #1 no ranking!")
```

### Endpoints REST (CBV Gamification System v1.1)
```
GET  /wp-json/cbv/v1/scores → top 3 por jogo (público)
POST /wp-json/cbv/v1/scores → guarda score (autenticado via cookies WP)
```

### Regras anti-duplicado
- Cada utilizador aparece só uma vez por jogo
- Se jogar de novo, só actualiza se o novo score for maior
- Scores guardados em `wp_options` (`cbv_scores_{gameId}`)
- Top 10 guardado, top 3 mostrado

### Scores por jogo
| Jogo | Variável score | Extra |
|---|---|---|
| basketman | `score` | `level` |
| chuva_bolas | `score` | — |
| puzzle | `Math.max(10, Math.floor((10000*GRID*GRID)/(seconds*moves)))` | `tries` (moves) |
| lancamentos | `pts` | — |
| memory | `finalScore` (via `calcScore()`) | `tries` |

### CBVGam métodos novos (v1.1)
```javascript
CBVGam.saveScore(gameId, score, extra, callback)
CBVGam.getScores(callback) // devolve {lancamentos:[...], basketman:[...], ...}
CBVGam.getState() // agora inclui username e display_name
```

---

## 8. ARQUITETURA CBVGam (SISTEMA DE MOEDAS)

### Padrão de integração — todos os jogos
```javascript
function cbvGam(){
  return window.CBVGam ||
    (window.parent && window.parent.CBVGam) ||
    (window.parent && window.parent.parent && window.parent.parent.CBVGam) || null;
}
// Verificar saldo
if(!gam.canPay(CUSTO)){ mostrarErro(); return; }
// Descontar
gam.payCoins(CUSTO, function(d){ if(d.sucesso) iniciarJogo(); });
// Adicionar prémio
gam.addCoins(coins, function(){});
// Reportar score (todos os jogos)
try{
  var msg={type:'cbv_score', gameId:'nome_jogo', entry:{score:X, level:Y}};
  if(window.parent) window.parent.postMessage(msg,'*');
  if(window.parent&&window.parent.parent) window.parent.parent.postMessage(msg,'*');
}catch(e){}
```

### Economia
```
Raspadinha (1x/dia) → 10 a 50 moedas
Ganhar jogo         → varia por jogo
BasketMan custo     → 5 moedas
Chuva Bolas custo   → 5 moedas
Puzzle custo        → 5 moedas
```

---

## 9. MENU — LÓGICA CADERNETA

```
Admin      → clica "Caderneta 25/26" → /caderneta/ com iframe
Utilizador → clica "Caderneta 25/26" → overlay "Em Breve" com capa_album.png
```

Tab no menu: fundo dourado sólido + animação `cadPulse`.
Iframe injectado via WPCode directamente no `.entry-content` da página.

---

## 10. CADERNETA — ARQUITETURA

```javascript
var CLOUD = 'dmwwjylsw';
function imgUrl(pid){
  return 'https://res.cloudinary.com/'+CLOUD+'/image/upload/c_fill,w_300,h_420,g_face/'+pid+'.jpg';
}
```

Escalões: Senior Masc/Femi (lendaria), Sub-18/16 (rara), Sub-14/Mini (comum).
Assets em `/public_html/Caderneta/` — `CadernetaViana.html`, `background.png`, `capa_album.png`, `lobo_cbv.png`, `openpack.mp4`.
Estado actual: só `localStorage` — sem persistência server-side ainda.

---

## 11. ESTADO ATUAL — FEATURES

### Site WordPress
| Feature | Estado |
|---|---|
| Parser FPB — calendário e resultados | ✅ |
| Sistema de membros + Login Google | ✅ |
| Galeria Flickr com slideshow | ✅ |
| SEO (Rank Math + Search Console) | ✅ |
| Menu personalizado | ✅ |
| Item "Caderneta 25/26" no menu | ✅ |
| Overlay "Em Breve" + iframe admin | ✅ |
| Página Junta-te a Nós completa | ⏳ aguarda Carlos |
| Horários atualizados | ⏳ aguarda Carlos |
| Página histórica do clube | ⏳ aguarda materiais |

### Jogos
| Feature | Estado |
|---|---|
| BasketMan | ✅ |
| Chuva de Bolas | ✅ |
| Puzzle | ✅ |
| Lançamentos | ✅ |
| Memory | ✅ |
| Drawer abre automaticamente | ✅ |
| Highscores globais (top 3 por jogo) | ✅ |
| Score por utilizador (1 entrada por user) | ✅ |
| Notificação com posição no ranking | ✅ |

### Caderneta
| Feature | Estado |
|---|---|
| Álbum com todos os escalões | ✅ |
| Fotos reais via Cloudinary | ✅ |
| Abertura de packs com vídeo | ✅ |
| Sistema CBVGam integrado | ✅ |
| **Persistência server-side álbum** | ⏳ PRÓXIMO |
| Compra de packs (100 moedas) | ⏳ |
| Gestão duplicados + trocas | ⏳ |

### Gamificação
| Feature | Estado |
|---|---|
| Sistema de moedas (CBVGam) | ✅ |
| Raspadinha diária | ✅ |
| Highscores globais | ✅ |
| Loja de pacotes (100 moedas) | ⏳ |
| Mercado de trocas | ⏳ |
| CRM atletas | ⏳ |

---

## 12. PRÓXIMOS PASSOS

### 🔴 Imediato
1. **Persistência server-side caderneta** — endpoint `/cbv/v1/colecao`:
   - GET → lê `ganhos` e `colados` do user_meta
   - POST → guarda `ganhos` e `colados` no user_meta
   - Caderneta sincroniza ao abrir e ao colar/ganhar cromos

### 🟡 A seguir
2. Compra de packs (100 moedas → 4 cromos)
3. Gestão de duplicados + trocas

### 🟢 Futuro
4. CRM atletas (role cbv_gestor)
5. Página histórica do clube
6. App Android/PlayStore

---

## 13. DECISÕES TÉCNICAS

| Decisão | Motivo |
|---|---|
| React bundlado inline (sem CDN) | CDNs bloqueados em alguns ambientes |
| Ghost element separado no drag-and-drop | Re-render no mousemove destroía DOM |
| Galeria Flickr via JSONP | CORS impede fetch() direto |
| Cloudinary com g_face | Crop automático centrado no rosto |
| postMessage jogos → jogos.html → WordPress | Cookies não passam em iframes cross-origin |
| CBVGam.saveScore() no header WP | Único contexto com cookies autenticados |
| Scores em wp_options (não tabela) | Simples, sem migração DB necessária |
| 1 score por utilizador por jogo | Evita spam no ranking |
| Versão nos comentários dos ficheiros | Permite confirmar versão no GitHub |

---

## 14. EQUIPA E CONTEXTO

| Pessoa | Papel |
|---|---|
| Alex | Gestor digital voluntário |
| Carlos | Conteúdos (inscrições, horários, materiais) |
| Vítor Viana | Presidente do clube |

### Ficheiros Hostinger
```
/public_html/Caderneta/    ← caderneta + assets
/public_html/jogos/        ← jogos HTML
/public_html/data/         ← CSV + cache FPB
```
