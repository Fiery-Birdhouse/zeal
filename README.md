**Zeal**
----------------

Zeal é um *software server-side* para compartilhamento de conhecimento, seja ele por meio de materiais didáticos, publicação e resolução de dúvidas ou discussões em grupo. Suas principais *features* são:

 - Interface gráfica responsiva e simplificada
 - Autenticação de usuário via Facebook
 - Compartilhamento de *e-books* 
 - Seção de dúvidas
 - *Chat* de discussões

Este é um sistema livre, isso significa que você pode contribuir com o desenvolvimento, assim como replicá-lo em seu servidor.

----------------
##### Desenvolvedores:
Utilize o seguinte modelo em seu `credenciais.json` para reproduzir o Zeal em seu ambiente:

```json
{
        "env":"dev",
        "timezone": "",
        "rootURL":"/zeal/",
        "appId":"",
        "appPass":"",
        "endTime": 1496880000,
        "dbProduction": {
                "host":"",
                "db":"",
                "user":"",
                "pass":""
        },
        "dbDev": {
                "host":"",
                "db":"",
                "user":"",
                "pass":""
        }
}
```
