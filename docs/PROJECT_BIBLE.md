# PROJECT BIBLE — CB Viana Digital
> Última atualização: 18 Abril 2026
> ⚠️ Atualizar sempre no fim de cada sessão de trabalho.

---

## 1. VISÃO GERAL

Site oficial do Clube de Basquetebol de Viana do Castelo + ecossistema digital de engagement para adeptos.

**URL produção:** https://cbviana.com  
**Repositório:** https://github.com/vianabasketball-maker/cbviana-digital  
**Cores:** Bordô `#7B1C2E` / `#6B1428` · Dourado `#F0A500` / `#FFB800`  
**Língua:** Português Europeu

---

## 2. STACK TÉCNICA

| Camada | Tecnologia |
|--------|-----------|
| CMS | WordPress (Hostinger) |
| Tema | WP Radiant Basketball Club |
| Page Builder | Elementor (abandonado — conflitos) → blocos HTML diretos |
| Snippets PHP | WPCode |
| Jogos/interativos | HTML/CSS/JS standalone em `/public_html/jogos/` |
| Apostas | `apostas.html` em `/public_html/jogos/apostas.html` |
| Gamificação | CBVGam (WPCode HTML snippet) |
| Cromos | React JSX (`caderneta-panini.jsx`) |
| App social media | Streamlit (cbviana-posts.streamlit.app) |
| Media | Cloudinary (cloud: `dmwwjylsw`) |
| Remove BG | remove.bg API |
| Dados atletas | Google Drive (`CB_Viana_Plantel_2025_2026.xlsx`) |

---

## 3. WORDPRESS — SNIPPETS WPCODE ATIVOS

| Nome snippet | Tipo | Função |
|---|---|---|
| CB Viana Menu | PHP | Header + menu + drawer mobile + overlays |
| CBV Gamification | PHP | Endpoints REST gamificação (`/cbv/v1/gamification`, `/cbv/v1/scores`) |
| CBV Apostas Sistema | PHP | Todos os endpoints REST apostas |
| CBV Beta Access | PHP | Role `beta_tester` + endpoint `/cbv/v1/apostas/acesso` |
| cbv-gamification-header | HTML | Widget CBVGam no header (v1.2 com método `sync`) |
| cbv-devmode-block | PHP | Bloqueia F12/DevTools para não-admins |

---

## 4. SISTEMA CBV APOSTAS

### 4.1 Ficheiros
- `apostas.html` → `/public_html/jogos/apostas.html` (v1.4)
- `cbv-apostas-wpcode.php` → WPCode "CBV Apostas Sistema"
- `cbv-beta-access.php` → WPCode "CBV Beta Access"
- Página WP `/apostas/` com iframe para `apostas.html`

### 4.2 Endpoints REST
| Endpoint | Método | Função |
|---|---|---|
| `/cbv/v1/apostas/jogos` | GET | Jogos futuros com odds (cache 24h) |
| `/cbv/v1/apostas/stats` | GET | Win rates das equipas (cache 24h) |
| `/cbv/v1/apostas/minhas` | GET | Apostas do utilizador autenticado |
| `/cbv/v1/apostas/apostar` | POST | Colocar aposta |
| `/cbv/v1/apostas/cancelar` | POST | Cancelar aposta pendente |
| `/cbv/v1/apostas/resolver` | POST | Resolver apostas (admin) |
| `/cbv/v1/apostas/notificacao` | GET | Ler/limpar notificação de login |
| `/cbv/v1/apostas/aceitar-aviso` | GET/POST | Guardar/verificar aceitação do aviso |
| `/cbv/v1/apostas/acesso` | GET | Verificar se utilizador tem acesso beta |
| `/cbv/v1/apostas/teste-resolver` | POST | ⚠️ REMOVER EM PRODUÇÃO — resolve manualmente |

### 4.3 Cache (pasta `/public_html/data_apostas/`)
| Ficheiro | TTL | Conteúdo |
|---|---|---|
| `ap_cal.html` | 24h | Calendário FPB |
| `ap_res.html` | Cron 2h | Resultados FPB |
| `ap_stats.json` | 24h | Win rates equipas |
| `ap_logomap.json` | 24h | Logos equipas |
| `ap_res_XXX.html` | 24h | Resultados por clube ID |

### 4.4 Cron WordPress
- Intervalo: cada 2 horas (`hourly` WP Cron)
- Resolve apostas pendentes com resultados reais
- Devolve moedas após 48h sem resultado (jogo não realizado)

### 4.5 Roles de acesso
- `administrator` → acesso completo
- `beta_tester` → acesso às apostas
- `subscriber` → vê overlay "em breve" ao clicar

### 4.6 Funcionalidades apostas.html (v1.4)
- Tab Jogos: Esta semana / As minhas (jogos de hoje visíveis até 30min após início)
- Tab Apostas: subtabs Pendentes / Ganhas / Perdidas
- Tab Equipas: ranking win rates
- Modal aposta: escolha equipa + valor (1,2,3,5,8,10 moedas)
- Cancelar aposta: botão + confirm dialog + devolução imediata
- Popup GANHA: moedas + link para `/apostas/`
- Aviso "Jogo Virtual": popup com checkbox "Não mostrar novamente" (cookie + user_meta)
- Deduplicação: um jogo = uma aposta (mais recente ganha)
- Integração CBVGam: `gam.payCoins()` + `cbvgam_paid:true` evita duplo desconto
- Sync saldo: `gam.sync()` após cancelar/ganhar

---

## 5. SISTEMA CBVGam (Gamificação)

### 5.1 Snippet: `cbv-gamification-header` (v1.2)
Widget no header WP — moedas, nível, progresso.

**Níveis:**
| Nível | Acessos | Bónus |
|---|---|---|
| Curioso | 0 | 0 |
| Adepto | 10 | 5 |
| Adepto Fiel | 30 | 15 |
| Bronze | 75 | 40 |
| Prata | 150 | 100 |
| Ouro | 300 | 250 |
| MVP | 500 | 500 |

**Métodos CBVGam:**
```javascript
CBVGam.addCoins(amount, callback)
CBVGam.payCoins(amount, callback)
CBVGam.canPay(amount) → boolean
CBVGam.getState() → {moedas, acessos, nivel, loggedIn, username, display_name}
CBVGam.saveScore(gameId, score, extra, callback)
CBVGam.getScores(callback)
CBVGam.sync(callback)  // v1.2 — re-fetch servidor + atualiza header + notifica iframes
```

**Endpoints REST gamificação:**
- `GET /cbv/v1/gamification` → estado do utilizador
- `POST /cbv/v1/gamification` → ações: `acesso`, `moedas`, `pagar`
- `GET/POST /cbv/v1/scores` → highscores dos jogos

---

## 6. MENU WORDPRESS (`cbv-viana-menu.php`)

### 6.1 Estrutura
```
Home | Quem Somos ▾ | Equipas | Blog | Galeria | Junta-te a Nós | Competições | Contacto | Caderneta 25/26 | TIMEOUT | Apostas[BETA]
```

**Submenu "Quem Somos":**
- O Clube → `/clube/`
- Direcção → `/direccao/`
- Treinadores → `/staff/`
- Instalações → `/instalacoes/`
- Horários de Treino → `/horarios/`
- Pais & Clube → `/pais-clube/`

### 6.2 Comportamentos especiais
| Item | Desktop | Mobile |
|---|---|---|
| Quem Somos | Dropdown hover | Accordion toggle |
| Caderneta | Admin → `/caderneta/` · Outros → overlay "EM BREVE" | igual |
| TIMEOUT | Botão dourado pulse | Badge dourado |
| Apostas | Fundo azul `#1a4a8a` + ribbon BETA dourado | Badge BETA dourado |

### 6.3 Overlays
- **Caderneta**: imagem da capa + "EM BREVE"
- **Apostas Beta**: explica moedas virtuais + jogos FPB + botão Login se não autenticado

---

## 7. SITE WORDPRESS — PÁGINAS

| Página | URL | Estado |
|---|---|---|
| Home | `/` | ✅ |
| O Clube | `/clube/` | ✅ |
| Direcção | `/direccao/` | ✅ |
| Treinadores | `/staff/` | ✅ |
| Equipas | `/equipas/` | ✅ |
| Pais & Clube | `/pais-clube/` | ✅ |
| Horários de Treino | `/horarios/` | ✅ |
| Instalações | `/instalacoes/` | ✅ |
| Blog | `/blog/` | ✅ |
| Junta-te a Nós | `/junta-te-a-nos/` | ✅ |
| Galeria | `/galeria/` | ✅ |
| Contacto | `/contacto/` | ✅ |
| Competições | `/desafios/` | ✅ |
| Caderneta | `/caderneta/` | ⏳ em breve |
| TIMEOUT (Jogos) | `/test/` | ✅ |
| Apostas | `/apostas/` | ✅ Beta |
| Login | `/login/` | ✅ |
| Account | `/account/` | ✅ |

---

## 8. JOGOS TIMEOUT (`/public_html/jogos/`)

| Ficheiro | Jogo | Estado |
|---|---|---|
| `jogos.html` | Hub de jogos | ✅ |
| `memory.html` | Memory cards | ✅ |
| `chuva_bolas.html` | Chuva de bolas | ✅ |
| `basketman.html` | Basketman | ✅ |
| `basketman3d.html` | Basketman 3D | ✅ |
| `lancamentos.html` | Lançamentos livres | ✅ |
| `puzzle.html` | Puzzle | ✅ |
| `basketball_stars.html` | Basketball Stars | ✅ |
| `apostas.html` | CBV Apostas | ✅ Beta |

---

## 9. CADERNETA DE CROMOS

- `caderneta-v4.jsx` → base aprovada: drag-and-drop, 3D page curl, tray lateral
- `caderneta-panini.jsx` → design Panini: 18 cards, fundo texturado, diagonal dourada
- `pack-opener.jsx` → abertura hiper-realista: Canvas tear, SVG jagged, vídeo intro
- Vídeo intro gerado via Pollo.ai
- Estado: ⏳ aguarda ligação ao sistema de moedas + database

---

## 10. APP STREAMLIT

- URL: https://cbviana-posts.streamlit.app
- Repo: `vianabasketball-maker/cbviana-app` (privado)
- Tabs: Aniversários · Jogos (FPB) · Fotos (Cloudinary)
- PWA: https://cbviana-posts.netlify.app

---

## 11. PENDENTE / PRÓXIMOS PASSOS

### Urgente
- [ ] ⚠️ Remover endpoint `teste-resolver` antes de lançamento público
- [ ] Limpar apostas canceladas antigas do `wp_options`
- [ ] Testar apostas com resultados reais (jogos de 18/04/2026)

### A médio prazo
- [ ] Abrir apostas ao público (remover restrição beta)
- [ ] Caderneta: ligar ao sistema de moedas + database
- [ ] Memory game com fotos reais de jogadores
- [ ] Integrar BasketMan e shooting game no site WP
- [ ] Migrar para hosting dedicado se necessário
- [ ] Zapier para distribuição automática de posts
- [ ] SEO + Google Search Console

### Futuro
- [ ] App Playstore (versão mobile nativa)
- [ ] Fantabasket (escolher equipa + pontuação real FPB)
- [ ] React migration da app Streamlit

---

## 12. DECISÕES TÉCNICAS IMPORTANTES

- **Iframe vs inline**: apostas.html servido via iframe na página WP — sem Elementor
- **CBVGam é fonte de verdade**: `payCoins()` desconta, PHP verifica `cbvgam_paid:true`
- **Popup aviso**: usa `user_meta` no servidor (localStorage/cookies bloqueados pelo Complianz em iframe)
- **Deduplicação apostas**: por `jogo_id`, mantém só a mais recente
- **Cron 2h**: resultados FPB + resolve apostas + devolução 48h sem resultado
- **Roles**: `administrator` e `beta_tester` acedem às apostas; `subscriber` vê overlay explicativo
- **Menu**: array PHP com suporte a submenus, caderneta, beta — tudo num snippet
- **SportsPress**: mantido só para Player Lists (shortcodes sem prefixo `sp_`)
- **PIL + DejaVu Sans**: para geração de imagens com caracteres portugueses no Streamlit
