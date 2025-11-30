# 📘 **API Bancos BR**

API pública para consulta de informações de Bancos Brasileiros, incluindo:

- Código do banco
- ISPB
- Nome e Nome Oficial
- Logos em SVG
- URLs amigáveis para servir arquivos estáticos
- Respostas JSON padronizadas

---

# 🚀 **Tecnologias Utilizadas**

- **PHP 8.3+**
- **MySQL 8**
- **Nginx ou Apache (ambos suportados)**
- **Regras de reescrita para rotas amigáveis**

---

# 🌐 **Base URL da API**

```
https://api.bancos.br.pedroaraujo.dev/
```

Todas as rotas começam com:

```
/api/
```

---

# 📡 **Endpoints Disponíveis**

## 📘 `GET /api/bancos`

Retorna a lista completa de bancos.

### Exemplo

```
https://api.bancos.br.pedroaraujo.dev/api/bancos
```

### Resposta

```json
{
  "error": false,
  "code": 200,
  "message": "Lista de bancos disponíveis",
  "total": 463,
  "data": [
    {
      "ISPB": 0,
      "codigo": "001",
      "nome": "BCO DO BRASIL S.A.",
      "nomeExtenso": "Banco do Brasil S.A.",
      "logo": null,
      "logoBranca": null,
      "logoPreta": null,
      "logoAlt": null,
      "logoIcone": "https://api.bancos.br.pedroaraujo.dev/api/u/001/logoIcone.svg"
    }...
  ]
}
```

---

## 📘 `GET /api/bancos/{codigo}`

Consulta um banco específico pelo código.

### Exemplo

```
https://api.bancos.br.pedroaraujo.dev/api/bancos/260
```

### Resposta

```json
{
  "error": false,
  "code": 200,
  "message": "",
  "total": 1,
  "data": [
    {
      "ISPB": 18236120,
      "codigo": "260",
      "nome": "NU PAGAMENTOS - IP",
      "nomeExtenso": "NU PAGAMENTOS S.A. - INSTITUIÇÃO DE PAGAMENTO",
      "logo": "https://api.bancos.br.pedroaraujo.dev/api/u/260/logo.svg",
      "logoBranca": "https://api.bancos.br.pedroaraujo.dev/api/u/260/logoBranca.svg",
      "logoPreta": null,
      "logoAlt": null,
      "logoIcone": "https://api.bancos.br.pedroaraujo.dev/api/u/260/logoIcone.svg"
    }
  ]
}
```

---

## 🎨 **Logos públicas em SVG**

As logos dos bancos ficam em URLs amigáveis como:

```
GET /api/u/{codigo}/{arquivo.svg}
```

Exemplo:

```
https://api.bancos.br.pedroaraujo.dev/api/u/104/logo.svg
```

Arquivos suportados:

- `logo.svg` → logo principal
- `logoBranca.svg`
- `logoPreta.svg`
- `logoIcone.svg`
- `logoAlt.svg`

### Parâmetro opcional: redimensionamento

```
?size=100
```

Exemplo:

```
/api/u/104/logo.svg?size=100
```

---

# 🗂️ **Estrutura Interna da API**

```
api/
 ├── config/
 │    ├── config.php
 │    ├── db.php
 │    ├── Schema.sql
 ├── endpoints/
 │    ├── bancos.php
 │    ├── logos.php
 ├── uploads/
 │    └── logos/
 │         ├── 001/
 │         ├── 003/
 │         └── ...
```

# 📜 **Regras de Rewrite**

Compatível com **Apache** e **NGINX**.

---

## 🔵 Apache (.htaccess)

```apache
RewriteEngine On
RewriteBase /

# Logos amigáveis
RewriteRule ^api/u/([0-9]+)/([^/]+)$ api/endpoints/logos.php?codigo=$1&arquivo=$2 [L,QSA]

# Listar bancos
RewriteRule ^api/bancos$ api/endpoints/bancos.php [L,QSA]

# Consultar banco específico
RewriteRule ^api/bancos/([^/]+)$ api/endpoints/bancos.php?id=$1 [L,QSA]

# Permitir arquivos estáticos
RewriteCond %{REQUEST_FILENAME} -f
RewriteRule . - [L]

# Segurança: bloquear acesso direto aos endpoints
RewriteRule ^api/endpoints/(.*)$ - [F]
```

---

## 🟣 NGINX

```nginx
rewrite ^/api/u/([0-9]+)/([^/]+)$ /api/endpoints/logos.php?codigo=$1&arquivo=$2 last;
rewrite ^/api/bancos$ /api/endpoints/bancos.php last;
rewrite ^/api/bancos/([^/]+)$ /api/endpoints/bancos.php?id=$1 last;

# Arquivos estáticos
location ~* \.(png|jpg|jpeg|gif|svg|webp|ico)$ {
    try_files $uri =404;
}

# Bloqueio de acesso direto aos PHP internos
location ~ ^/api/endpoints/.+\.php$ {
    internal;
}
```

---

# 🛠️ **Erros & Respostas da API**

A API utiliza respostas JSON padronizadas.

### Exemplo de erro:

```json
{
  "error": true,
  "code": 404,
  "message": "Banco não encontrado"
}
```

---

# 📌 STATUS da API

- Acesso público
- Sem autenticação
- Sem rate limit (por enquanto)
- Logos públicas
- Dados atualizados periodicamente

---

# 📧 Contato

📩 **[pedro.s.araujo291@gmail.com](mailto:pedro.s.araujo291@gmail.com)**

---
