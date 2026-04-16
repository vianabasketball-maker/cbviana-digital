# PROJECT BIBLE — CB Viana Digital
> Documento de contexto unificado para continuação por qualquer Claude.
> Última atualização: Abril 2026
> 🔗 Repositório: https://github.com/vianabasketball-maker/cbviana-digital

---

## ⚡ PROTOCOLO OBRIGATÓRIO — LÊ ISTO PRIMEIRO

### 🟢 INÍCIO DE CADA SESSÃO — O Claude deve fazer isto automaticamente:

1. Lê este BIBLE completo
2. Confirma ao utilizador: *"Li o PROJECT_BIBLE. Aqui está o estado actual do projecto: [resumo]. O próximo passo é: [passo 1 da Secção 10]."*
3. Pergunta: *"O que queres trabalhar hoje?"*
4. Antes de alterar qualquer ficheiro, lê o código actual do GitHub com `web_fetch` usando os URLs da Secção 4

### 🔴 FIM DE CADA SESSÃO — O Claude deve fazer isto automaticamente:

1. Gerar o BIBLE actualizado com tudo o que foi feito
2. Avisar o utilizador: *"Sessão terminada. Aqui está o BIBLE actualizado. Faz o upload para o GitHub agora."*
3. O utilizador faz: GitHub → `docs/PROJECT_BIBLE.md` → Edit → cola o novo conteúdo → Commit

### ⚠️ REGRA DE OURO
**Nunca termines uma sessão sem fazer upload do BIBLE actualizado para o GitHub.**
O GitHub é a única fonte de verdade. O que não estiver no GitHub não existe para o próximo Claude.

### 📋 PROMPT PARA INICIAR QUALQUER SESSÃO NOVA
Cola isto como primeira mensagem em qualquer nova conversa:
```
Lê o PROJECT_BIBLE do projecto CB Viana e confirma o estado actual:
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

**C) Sistema de gamificação com persistência** — backend WordPress com DB MySQL (EM CONSTRUÇÃO):
- Moedas por utilizador
- Coleção de cromos por utilizador
- Mercado de trocas entre utilizadores
- CRM de atletas (role cbv_gestor)

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
Clube ID: 723  |  Época: 2025/2026
Calendário: https://www.fpb.pt/calendario/clube_723/?clube=723&epoca=2025/2026
Resultados:  https://www.fpb.pt/resultados/clube_723/?clube=723&epoca=2025/2026
Cache:       /public_html/data/fpb_cal8.html e fpb_res8.html (gerados a cada 6h)
```

---

## 4. RAW URLS — REPOSITÓRIO COMPLETO

> Usa estes URLs com `web_fetch` para ler o código de qualquer ficheiro.

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

### PAGES-HTML (ficheiros standalone na raiz do Hostinger)
```
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/pages-html/cbv-mascote-animacao.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/pages-html/colecao.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/pages-html/em_construcao.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/pages-html/formacao.html
https://raw.githubusercontent.com/vianabasketball-maker/cbviana-digital/main/pages-html/raspadinha.html
```

### WP-BLOCKS (fragmentos HTML custom das páginas WordPress)
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
> Nota equipas: botão animado repetido, só muda o href. Ver equipas-hub.html como template.

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
| Raspadinha | /raspadinha | wp-blocks/raspadinha (via pages-html) |
| Galeria | /galeria | wp-blocks/galeria.html |
| Clube | /clube | wp-blocks/clube.html |
| Contacto | /contacto | wp-blocks/contacto.html |
| Staff e Treinadores | /staff | wp-blocks/staff.html |
| Instalações | /instalacoes | wp-blocks/instalacoes.html |
| Pais & Clube | /pais-clube | wp-blocks/pais-clube.html |
| TIMEOUT | /test | wp-blocks/timeout.html |
| Equipas | /equipas | Gutenberg + wp-blocks/equipas/equipas-hub.html |
| Mini 10 | /mini-10-masculino | wp-blocks/equipas/mini10.html |
| Mini 12 | /mini-12-feminino | wp-blocks/equipas/mini12.html |
| Sénior Masc | /senior-masculino | wp-blocks/equipas/senior.html |
| Sub 14 | /sub-14-feminino | wp-blocks/equipas/sub14.html |
| Sub 16 | /sub-16-feminino | wp-blocks/equipas/sub16.html |
| Sub 18 | /sub-18-feminino | wp-blocks/equipas/sub18.html |
| Login | /login | `[nextend_social_login]` + `[ultimatemember form_id="447"]` |
| Register | /register | `[nextend_social_login]` + `[ultimatemember form_id="446"]` |
| Account | /account | `[ultimatemember_account]` |
| User | /user | `[ultimatemember form_id="448"]` |
| Members | /members | `[ultimatemember form_id="449"]` |
| Blog | /blog | Posts Page |
| Direcção | /direccao | Só Gutenberg |
| Cookie Policy | /cookie-policy-eu | Só Gutenberg |
| Política Privacidade | /privacy-policy | Só Gutenberg |

---

## 6. SNIPPETS

### WPCode
| ID | Nome | Localização | Tipo | Função |
|---|---|---|---|---|
| 601 | CBV Gamification System | Run Everywhere | PHP | Sistema central moedas + endpoints REST |
| 605 | CBV Admin | Run Everywhere | PHP | Painel admin da gamificação |
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

### Insert PHP Code Snippet
| Shortcode | Função |
|---|---|
| `[xyz-ips snippet="avatar"]` | Avatar do utilizador no header |
| `[xyz-ips snippet="jogos-home"]` | Próximos jogos na Home |
| `[xyz-ips snippet="jogos-fpb"]` | Calendário + resultados FPB |
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

// Verificar saldo
var gam = cbvGam();
if (gam && !gam.canPay(CUSTO)) {
  var s = gam.getState();
  mostrarErro('Precisas de ' + CUSTO + ' moedas. Tens ' + s.moedas);
  return;
}

// Descontar moedas para jogar
gam.payCoins(CUSTO, function(d) {
  if (d.sucesso) { iniciarJogo(); }
});

// Adicionar moedas como prémio
gam.addCoins(Math.floor(score / 50), function() {});

// Reportar pontuação cross-iframe via postMessage
window.parent.postMessage({
  type: 'cbv_score',
  gameId: 'basketman',
  entry: { name: nome, score: score, level: level }
}, '*');
```

### Economia
```
Raspadinha (1x/dia) → 10 a 50 moedas aleatório
Ganhar jogo         → Math.floor(score / 50) moedas
Comprar pack        → 100 moedas → 4 cromos
BasketMan custo     → 5 moedas
Chuva Bolas custo   → 5 moedas
```

---

## 8. CADERNETA — ARQUITETURA

### Cloudinary
```javascript
var CLOUD = 'dmwwjylsw';
function imgUrl(pid) {
  return 'https://res.cloudinary.com/' + CLOUD + '/image/upload/c_fill,w_300,h_420,g_face/' + pid + '.jpg';
}
// pid = ID do ficheiro no Cloudinary ex: 'Afonso_Lima_da_Silva_gl7z5x'
// g_face = crop automático centrado no rosto
```

### Escalões e raridades
```javascript
var ESCALOES = [
  { key: 'Senior_Masc',  titulo: 'Sénior Masculino',  raridade: 'lendaria', jogadores: [...] },
  { key: 'Senior_Femi',  titulo: 'Sénior Feminino',   raridade: 'lendaria', jogadores: [...] },
  { key: 'Sub_18_Masc',  titulo: 'Sub-18 Masculino',  raridade: 'rara',     jogadores: [...] },
  { key: 'Sub_18_Femi',  titulo: 'Sub-18 Feminino',   raridade: 'rara',     jogadores: [...] },
  { key: 'Sub_16_Masc',  titulo: 'Sub-16 Masculino',  raridade: 'rara',     jogadores: [...] },
  { key: 'Sub_16_Femi',  titulo: 'Sub-16 Feminino',   raridade: 'rara',     jogadores: [...] },
  // + Sub-14, Sub-12, Mini-10 — ver código completo no GitHub
];
```

### Assets (Hostinger /public_html/Caderneta/)
```
CadernetaViana.html  ← ficheiro principal
background.png
capa_album.png
lobo_cbv.png
openpack.mp4         ← vídeo abertura de pack (949KB)
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

### Caderneta / Jogos
| Feature | Estado |
|---|---|
| Álbum com todos os escalões | ✅ |
| Fotos reais via Cloudinary | ✅ |
| Abertura de packs com vídeo | ✅ |
| Raridades por escalão | ✅ |
| Sistema CBVGam integrado | ✅ |
| BasketMan | ✅ |
| Chuva de Bolas | ✅ |
| Puzzle | ✅ |
| Lançamentos | ✅ |
| Memory | ✅ |
| jogos.html com drawer lateral | ✅ |
| Highscores via postMessage | ✅ |
| Persistência server-side álbum | ⏳ |
| Troca de cartas entre utilizadores | ⏳ |

### Gamificação
| Feature | Estado |
|---|---|
| CBV Gamification System (#601) | ✅ em produção |
| Raspadinha diária com moedas | ✅ em produção |
| Sistema de moedas (CBVGam) | ✅ em produção |
| Loja de pacotes (100 moedas) | ⏳ |
| Mercado de trocas | ⏳ |
| CRM atletas (role cbv_gestor) | ⏳ |

---

## 10. PRÓXIMOS PASSOS (por prioridade)

### 🔴 Imediato
1. Loja de pacotes com débito de moedas
2. Mercado de trocas (interface + lógica backend)

### 🟡 A seguir
3. Persistência server-side da caderneta
4. CRM atletas (role cbv_gestor + interface)

### 🟢 Futuro
5. Página histórica do clube (aguarda materiais Carlos)
6. App Android/PlayStore

---

## 11. DECISÕES TÉCNICAS

| Decisão | Motivo |
|---|---|
| React bundlado inline (sem CDN) | CDNs bloqueados em alguns ambientes → página preta |
| Ghost element separado no drag-and-drop | Re-render no mousemove destroía DOM, perdia mouseup |
| Galeria Flickr via JSONP | CORS impede fetch() direto |
| Cloudinary com g_face | Crop automático centrado no rosto dos jogadores |
| postMessage para highscores | localStorage bloqueado cross-origin em iframes |
| CBVGam via window.parent chain | Jogos em iframe precisam aceder sistema de moedas |
| MySQL WordPress (não Supabase) | Sem custo extra, integrado com WP users |
| Snippets WPCode sem extensão no GitHub | Nome copiado directamente do WPCode |

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
/public_html/jogos/             ← jogos HTML
/public_html/data/              ← CSV + cache FPB (gerada a cada 6h)
/public_html/colecao.html
/public_html/raspadinha.html
/public_html/cbv-mascote-animacao.html
/public_html/formacao.html
/public_html/em_construcao.html
```
