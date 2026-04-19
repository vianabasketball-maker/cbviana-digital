# PROJECT BIBLE — CB Viana Digital
> Documento de contexto unificado para continuação por qualquer Claude.
> Última atualização: 2026-04-19
> ⚠️ SEMPRE atualizar este ficheiro no fim de cada sessão de trabalho.
> 🔗 Repositório: https://github.com/vianabasketball-maker/cbviana-digital

---

## INSTRUÇÃO PARA O PRÓXIMO CLAUDE

1. Lê a **Secção 9** para perceber o que está feito
2. Lê a **Secção 10** para perceber o próximo passo
3. Usa os raw URLs da **Secção 4** para ler o código real com `web_fetch`
4. Nunca recomeças do zero — continua de onde ficou
5. No fim da sessão, atualiza este ficheiro e faz upload para `docs/PROJECT_BIBLE.md` no GitHub

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
- **CBV Apostas** (novo — em produção)

**C) Sistema de gamificação com persistência** — backend WordPress com DB MySQL:
- Moedas por utilizador
- Coleção de cromos por utilizador
- Mercado de trocas entre utilizadores (⏳)
- CRM de atletas (role cbv_gestor) (⏳)

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
| LiteSpeed Cache | 7.8.1 | Cache (inactivo) |
| Max Mega Menu | 3.8.1 | Menu (inactivo) |

### Serviços externos
| Serviço | Detalhe |
|---|---|
| Cloudinary | Cloud: `dmwwjylsw` |
| Flickr | User ID: `136430889@N05`, API Key: `615d446b553f45a1a89ea5214aab2a09` |
| Google | vianabasketball@gmail.com |
| GitHub | https://github.com/vianabasketball-maker/cbviana-digital (público) |

### FPB
```
Clube ID: 723  |  Época: 2025/2026  |  Padrão sigla Viana: 'VIA'
Calendário: https://www.fpb.pt/calendario/clube_723/?clube=723&epoca=2025/2026
Resultados:  https://www.fpb.pt/resultados/clube_723/?clube=723&epoca=2025/2026
Cache local: /public_html/data/fpb_cal8.html e fpb_res8.html (cache 1h, snippet jogos-fpb)
Timestamp último refresh: wp_option 'cbv_fpb_ultimo_refresh'
```

---

## 4. RAW URLS — REPOSITÓRIO COMPLETO

> Usa estes URLs com `web_fetch` para ler o código de qualquer ficheiro.

### APOSTAS (NOVO)
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
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/caderneta/background.png
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/caderneta/capa_album.png
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/caderneta/lobo_cbv.png
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/caderneta/openpack.mp4
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
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/cbv-apostas-wpcode
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/cbv-beta-access
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/wpcode/php/cbv-admin-stats
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

### DATA
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/data/horarios.csv
```

### DOCS
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/docs/PROJECT_BIBLE.md
```

---

## 5. PÁGINAS WORDPRESS

| Página | Slug | Conteúdo |
|---|---|---|
| Home / Front Page | /home | `[xyz-ips snippet="jogos-home"]` |
| Competições | /desafios | `[xyz-ips snippet="jogos-fpb"]` + Gutenberg |
| Horários | /horarios | `[xyz-ips snippet="horarios"]` |
| Junta-te a Nós | /junta-te-a-nos | `[cbv_inscricoes]` (wpcode #625) |
| Coleção | /colecao | `<iframe src="/colecao.html">` |
| Raspadinha | /raspadinha | pages-html/raspadinha.html |
| Apostas | /apostas | `<iframe src="/jogos/apostas.html">` |
| Galeria | /galeria | wp-blocks/galeria.html |
| Clube | /clube | wp-blocks/clube.html |
| Contacto | /contacto | wp-blocks/contacto.html |
| Staff e Treinadores | /staff | wp-blocks/staff.html |
| Instalações | /instalacoes | wp-blocks/instalacoes.html |
| Pais & Clube | /pais-clube | wp-blocks/pais-clube.html |
| TIMEOUT | /test | wp-blocks/timeout.html |
| Equipas | /equipas | Gutenberg + wp-blocks/equipas/equipas-hub.html |
| Login | /login | `[nextend_social_login]` + `[ultimatemember form_id="447"]` |
| Register | /register | `[nextend_social_login]` + `[ultimatemember form_id="446"]` |
| Account | /account | `[ultimatemember_account]` |
| User | /user | `[ultimatemember form_id="448"]` |
| Members | /members | `[ultimatemember form_id="449"]` |
| Blog | /blog | Posts Page |

---

## 6. SNIPPETS

### WPCode
| ID | Nome | Localização | Tipo | Função |
|---|---|---|---|---|
| 601 | CBV Gamification System | Run Everywhere | PHP | Sistema central moedas + endpoints REST |
| 605 | CBV Admin | Run Everywhere | PHP | Painel admin da gamificação (raspadinha) |
| 624 | CB Viana Menu | Run Everywhere | PHP | Menu principal do site |
| 625 | Inscrições | Run Everywhere | PHP | Shortcode `[cbv_inscricoes]` |
| 642 | BlocoDevMode | Run Everywhere | PHP | Proteção DevTools/F12 |
| 593 | foto_puzzle | Run Everywhere | PHP | Fotos Puzzle via Cloudinary |
| 596 | cbv-raspadinha-php4 | Run Everywhere | PHP | Lógica PHP da raspadinha |
| 597 | cbv-gamification-header | Site Wide Header | HTML | UI de moedas no header |
| 600 | notificação_raspadinha | Site Wide Footer | HTML | Notificação raspadinha footer |
| 616 | Explicação | Site Wide Header | HTML | Tutorial/explicação |
| 525 | Pop-up Registration | Site Wide Body | HTML | Pop-up de registo |
| 237 | UnderConstructionPage | — | JS | Página em construção |
| NEW | cbv-apostas-wpcode | Run Everywhere | PHP | Sistema CBV Apostas completo |
| NEW | cbv-beta-access | Run Everywhere | PHP | Role beta_tester + endpoint acesso |
| NEW | cbv-admin-stats | Run Everywhere | PHP | Dashboard admin WP (Apostas+Jogos+Users) |

### Insert PHP Code Snippet
| Shortcode | Função |
|---|---|
| `[xyz-ips snippet="avatar"]` | Avatar do utilizador no header |
| `[xyz-ips snippet="jogos-home"]` | Próximos jogos na Home |
| `[xyz-ips snippet="jogos-fpb"]` | Calendário + resultados FPB (v1.1 — avisa apostas) |
| `[xyz-ips snippet="horarios"]` | Tabela horários de treinos |

---

## 7. ARQUITETURA CBVGam (SISTEMA DE MOEDAS)

### Padrão de integração — usado em TODOS os jogos
```javascript
function cbvGam() {
  return window.CBVGam ||
    (window.parent && window.parent.CBVGam) ||
    (window.parent && window.parent.parent && window.parent.parent.CBVGam) || null;
}
// addCoins, payCoins, canPay, getState, sync — ver cbv-gamification-header
```

### Economia
```
Raspadinha (1x/dia)  → 10 a 50 moedas aleatório
Ganhar jogo          → Math.floor(score / 50) moedas
Comprar pack         → 100 moedas → 4 cromos
BasketMan custo      → 5 moedas
Chuva Bolas custo    → 5 moedas
Apostas máximo       → 50 moedas por aposta
```

---

## 8. CBV APOSTAS — ARQUITETURA

### Ficheiros
```
/public_html/jogos/apostas.html     ← UI iframe (v1.9)
WPCode: cbv-apostas-wpcode          ← PHP backend (v1.2)
WPCode: cbv-beta-access             ← Role + acesso (v1.2)
WPCode: cbv-admin-stats             ← Dashboard admin (v1.3)
```

### Endpoints REST /cbv/v1/apostas/
```
GET  /jogos          → jogos futuros com odds (lê fpb_cal8.html local)
GET  /resultados     → jogos passados (lê fpb_res8.html local)
GET  /minhas         → apostas do utilizador
POST /apostar        → colocar aposta (param cbvgam_paid=true)
POST /cancelar       → cancelar aposta pendente
POST /resolver       → resolver apostas (admin)
GET  /notificacao    → notificação login
GET+POST /aceitar-aviso → aviso jogo virtual
GET  /acesso         → verificar role beta_tester/admin
GET  /refresh-info   → último/próximo refresh timestamp
POST /enriquecer     → atualiza apostas antigas com dados FPB (admin)
```

### Lógica de Odds (baseada no último jogo desta época)
```
Viana GANHOU último jogo → Viana ×2.00 / Adversário ×1.75 (favorito)
Viana PERDEU último jogo → Viana ×4.00 / Adversário ×1.25 (azarão!)
Sem histórico            → Viana ×3.00 / Adversário ×1.50 (base)
Jogo sem Viana           → ×1.85 / ×1.85 (neutro)
```

### Cache FPB (partilhada com snippet jogos-fpb)
```
/public_html/data/fpb_cal8.html  → calendário (cache 1h)
/public_html/data/fpb_res8.html  → resultados (cache 1h)
wp_option: cbv_fpb_ultimo_refresh → timestamp último refresh
```

### Cron
- `cbv_apostas_cron` corre a cada 2h
- Lê `fpb_res8.html` (local, sem fetch próprio)
- Resolve apostas com resultado
- Deteta jogos cancelados (desapareceram após 24h) → reembolso + 1🪙 bónus
- Devolução automática após 48h sem resultado

### Dados guardados em cada aposta
```
id, uid, username, jogo_id, escolha, montante, odd,
sigla_casa, sigla_fora, logo_casa, logo_fora,
comp, data, hora, pct_casa, pct_fora, odd_casa, odd_fora,
estado, ts_jogo, criada_em, resolvida_em, ganhou, payout, notificado
```

---

## 9. ESTADO ATUAL — FEATURES

### Site WordPress
| Feature | Estado |
|---|---|
| Parser FPB — calendário e resultados | ✅ |
| RGPD / cookies (Complianz) | ✅ |
| Sistema de membros (Ultimate Member) | ✅ |
| Login com Google (Nextend) | ✅ |
| Redirect após login → homepage | ✅ |
| Galeria Flickr com slideshow | ✅ |
| SEO (Rank Math + Search Console) | ✅ |
| Formulário de contactos | ✅ |
| Horários de treinos via CSV | ✅ |
| Proteção DevTools/F12 | ✅ |
| Menu principal personalizado | ✅ |
| Pop-up de registo | ✅ |
| Avatar no header | ✅ |
| Páginas de equipas (6 escalões) | ✅ |
| Página Junta-te a Nós completa | ⏳ aguarda info Carlos |
| Horários atualizados | ⏳ aguarda CSV Carlos |
| Página histórica do clube | ⏳ aguarda materiais |
| Logos patrocinadores | ⏳ |

### CBV Apostas
| Feature | Estado |
|---|---|
| Sistema completo em produção | ✅ |
| Odds baseadas no último jogo da época | ✅ |
| Limite 50 moedas por aposta | ✅ |
| Input numérico livre (1-50) | ✅ |
| Badge contexto (favorito/azarão/base) | ✅ |
| Timestamp próximo refresh | ✅ |
| Deteção jogo cancelado + reembolso +1🪙 | ✅ |
| Toast cancelamento com detalhes saldo | ✅ |
| Dashboard admin (CBV Stats) | ✅ |
| Aberto a todos (sem beta wall) | ✅ |
| Raspadinha múltipla — fix proximaRaspadinha | ⚠️ PENDENTE |

### Caderneta / Jogos
| Feature | Estado |
|---|---|
| Álbum com todos os escalões | ✅ |
| Fotos reais via Cloudinary | ✅ |
| Abertura de packs com vídeo | ✅ |
| Raridades por escalão | ✅ |
| Sistema CBVGam integrado | ✅ |
| BasketMan, Chuva de Bolas, Puzzle, Lançamentos, Memory | ✅ |
| Highscores via postMessage | ✅ |
| Persistência server-side álbum | ⏳ |

### Gamificação
| Feature | Estado |
|---|---|
| CBV Gamification System | ✅ em produção |
| Raspadinha diária com moedas | ✅ em produção |
| Sistema de moedas (CBVGam) | ✅ em produção |
| Dashboard admin CBV Stats | ✅ WP Admin → CBV Stats |
| Loja de pacotes (100 moedas) | ⏳ |
| Mercado de trocas | ⏳ |

---

## 10. PRÓXIMOS PASSOS (por prioridade)

### 🔴 Imediato
1. **Fix raspadinha múltipla** — `proximaRaspadinha()` em `raspadinha.html` precisa de reset completo do DOM do canvas antes de chamar `setupScratch`. Ver secção 8 acima para o código correto.
2. **Commit GitHub** de todos os ficheiros de hoje (apostas.html, cbv-apostas-wpcode, cbv-beta-access, cbv-admin-stats, jogos-fpb)

### 🟡 A seguir
3. **Página "Ajuda a Melhorar"** — nova entrada no menu após Contacto com formulário de sugestões/erros
4. **Post Facebook** — anunciar abertura beta apostas + menu sugestões + novo jogo
5. Loja de pacotes com débito de moedas
6. Mercado de trocas (interface + lógica backend)

### 🟢 Futuro
7. CRM atletas (role cbv_gestor + interface)
8. Página histórica do clube (aguarda materiais Carlos)
9. App Android/PlayStore

---

## 11. DECISÕES TÉCNICAS

| Decisão | Motivo |
|---|---|
| Apostas leem fpb_cal8/res8 do site | Zero fetches duplos — partilha cache com snippet jogos-fpb |
| Odds por último jogo da época | Contextual para site de clube — sem necessidade de IDs FPB |
| Dados do jogo guardados na aposta | Permite mostrar card mesmo após jogo desaparecer da FPB |
| cbv_gam_add_coins → update_user_meta | Função inexistente — usa directamente cbv_moedas user_meta |
| beta_tester → subscriber para Giulia | UM não reconhece roles custom → redirect forçado para perfil |
| CBVGam via window.parent chain | Jogos em iframe precisam aceder sistema de moedas |
| React bundlado inline (sem CDN) | CDNs bloqueados em alguns ambientes → página preta |
| postMessage para highscores | localStorage bloqueado cross-origin em iframes |

---

## 12. EQUIPA E CONTEXTO

| Pessoa | Papel |
|---|---|
| Alex | Gestor digital voluntário |
| Carlos | Fornece conteúdos (inscrições, horários, materiais históricos) |
| Vítor Viana | Presidente do clube |

### Ficheiros no servidor Hostinger
```
/public_html/Caderneta/         ← caderneta + assets
/public_html/jogos/             ← jogos HTML + apostas.html
/public_html/data/              ← CSV + cache FPB (fpb_cal8.html, fpb_res8.html)
/public_html/data_apostas/      ← ap_logomap.json (único ficheiro restante)
/public_html/colecao.html
/public_html/raspadinha.html
```

### Nota Ultimate Member + roles custom
O UM não reconhece roles WordPress custom (ex: `beta_tester`) e força redirect para o perfil do utilizador ao navegar. Solução: usar role `subscriber` + verificar acesso por `user_meta('cbv_beta_access', '1')` para funcionalidades restritas.
