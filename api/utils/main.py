import os
import mysql.connector

BASE_DIR = "/Users/pedro/GitHub/api-bancos-br/api/uploads/logos"
URL_BASE = "https://api.bancos.br.pedroaraujo.dev/api/"  # <<< SUA URL

# -----------------------------
# Conexão com MySQL
# -----------------------------
conn = mysql.connector.connect(
    host="127.0.0.1",
    user="root",
    password="cimatec",
    database="api_bancos_br"
)
cursor = conn.cursor()

# -----------------------------
# Processar cada pasta de banco
# -----------------------------
for pasta in os.listdir(BASE_DIR):
    caminho_pasta = os.path.join(BASE_DIR, pasta)

    if not os.path.isdir(caminho_pasta):
        continue

    codigo = pasta.zfill(3)

    # Campos da tabela
    campos = {
        "logo": None,
        "logoBranca": None,
        "logoPreta": None,
        "logoAlt": None,
        "logoIcone": None
    }

    # Ler todos os arquivos válidos
    for arquivo in os.listdir(caminho_pasta):
        caminho_relativo = f"uploads/logos/{codigo}/{arquivo}"
        url_completa = URL_BASE + caminho_relativo

        match arquivo:
            case "logo.svg":
                campos["logo"] = url_completa

            case "logoBranca.svg":
                campos["logoBranca"] = url_completa

            case "logoPreta.svg":
                campos["logoPreta"] = url_completa

            case "logoAlt.svg":
                campos["logoAlt"] = url_completa

            case "logoIcone.svg":
                campos["logoIcone"] = url_completa

    print(f"[{codigo}] → {campos}")

    # -----------------------------
    # Atualizar no banco
    # -----------------------------
    cursor.execute("""
        UPDATE Bancos SET
            logo = %s,
            logoBranca = %s,
            logoPreta = %s,
            logoAlt = %s,
            logoIcone = %s
        WHERE codigo = %s
    """, (
        campos["logo"],
        campos["logoBranca"],
        campos["logoPreta"],
        campos["logoAlt"],
        campos["logoIcone"],
        codigo
    ))

conn.commit()
cursor.close()
conn.close()

print("\n✔ Atualização concluída com sucesso!")
'360305', '104', 'CAIXA ECONOMICA FEDERAL', 'CAIXA ECONOMICA FEDERAL', 'https://api.bancos.br.pedroaraujo.dev/uploads/logos/104/logo.svg', NULL, NULL, NULL, 'https://api.bancos.br.pedroaraujo.dev/uploads/logos/104/logoIcone.svg'
