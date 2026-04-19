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
| cbv-apostas-wpcode | PHP | Sistema apostas completo |
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

### Cache FPB (partilhada com jogos-fpb)
```
/public_html/data/fpb_cal8.html  (cache 1h)
/public_html/data/fpb_res8.html  (cache 1h)
```

### Cron
- `cbv_apostas_cron` — cada 2h
- Resolve apostas, deteta jogos cancelados (+1🪙 bónus), devolução 48h

---

## 9. HIGHSCORES GLOBAIS

```
GET  /cbv/v1/scores → top 3 por jogo
POST /cbv/v1/scores → guarda score
```

Fluxo: jogo → postMessage → jogos.html → WordPress (cbv-gamification-header) → API

---

## 10. MENU — CB Viana Menu v1.2

```php
// Estrutura array $nav
[label, url, special, caderneta, beta, submenu[], classe_extra]

// Controlo apostas
$is_beta = true;  // mudar para false para fechar

// Itens especiais
'caderneta'   → dourado pulsante (overlay "Em Breve" para não-admins)
'special'     → dourado sólido (TIMEOUT)
'apostas-beta'→ azul com ribbon BETA
'ajuda'       → verde transparente rgba(26,92,58,0.5)
```

---

## 11. RASPADINHA v2.1

- Fix `proximaRaspadinha()` — reset completo DOM canvas
- Botões após raspar: "Ver a minha Coleção" + "Voltar à Home"
- Múltiplas raspadinhas pendentes suportadas

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
| Post Facebook apostas + ajuda | ⏳ |
| Persistência server-side caderneta | ⏳ |
| Loja de pacotes (100 moedas) | ⏳ |
| Mercado de trocas | ⏳ |
| Página Junta-te a Nós | ⏳ aguarda Carlos |
| Horários actualizados | ⏳ aguarda Carlos |

---

## 14. PRÓXIMOS PASSOS

### 🟡 Imediato
1. **Post Facebook** — anunciar apostas abertas + Ajuda-nos a Crescer
2. **Imagens Fintas + logo** — substituir placeholders em wp-blocks/ajuda.html

### 🟢 Futuro
3. Persistência server-side caderneta (endpoint /cbv/v1/colecao)
4. Loja de pacotes (100 moedas → 4 cromos)
5. Mercado de trocas
6. Página histórica (aguarda Carlos)

---

## 15. DECISÕES TÉCNICAS

| Decisão | Motivo |
|---|---|
| UM restringe /apostas | Mais limpo que beta-wall manual |
| $is_beta = true | Apostas abertas — false para fechar |
| Aviso comentado | Rollback fácil |
| Cache FPB partilhada | Zero fetches duplos |
| Dados jogo guardados na aposta | Card visível mesmo após jogo sair da FPB |
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
/public_html/jogos/      ← jogos + apostas.html
/public_html/data/       ← cache FPB
/public_html/Caderneta/  ← caderneta + assets
/public_html/data_apostas/ ← ap_logomap.json
```
