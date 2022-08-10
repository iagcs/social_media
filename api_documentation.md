# Api Documentation

# `Route Login`

- **Post**
    - localhost:8000/api/login
    - Body
        
        `{`
        
        `“email” : “email@example.com”,`
        
        `“password”: “password”`
        
        `}`
        
    - Retorno
        - `{
            "accessToken":{
                "name":"JWT",
                "abilities":[
                    "*"
                ],
                "expires_at":null,
                "tokenable_id":11,
                "tokenable_type":"App\\Models\\User",
                "updated_at":"2022-08-10T05:20:37.000000Z",
                "created_at":"2022-08-10T05:20:37.000000Z",
            "id":4
            },
            "plainTextToken":"4|tdwtgNqHv1W8He9mcayghF0UOrqQovMGP48rmuYc"
        }`
    

# `Route Register`

- **Post**
    - localhost:8000/api/register
    - Body
        
        `{`
        
        `“name” : ”James”` 
        
        `“email” : “email@example.com”,`
        
        `“password”: “password”`
        
        `}`
        
    - Retorno
        
        `{`
        
        `“mensagem” : ”Registrado com sucesso.”` 
        
        `}`
        
    

# `Route Post Get`

- **Get**
    - localhost:8000/api/post
    - Body
    - Retorno
        
        {
            "posts": [
                {
                    "id": 1,
                    "description": "Ab accusamus natus ab alias. Totam quo veniam ex cupiditate labore facere.",
                    "user": [
                        {
                            "id": 1,
                            "name": "Cathrine Cole",
                            "email": "[dion.gusikowski@example.net](mailto:dion.gusikowski@example.net)"
                        }
                    ]
                },
                {
                    "id": 2,
                    "description": "Repudiandae ratione autem ut voluptatibus ut dolores. Quas cupiditate qui corporis a at.",
                    "user": [
                        {
                            "id": 1,
                            "name": "Cathrine Cole",
                            "email": "[dion.gusikowski@example.net](mailto:dion.gusikowski@example.net)"
                        }
                    ]
                }
            ]
        }
        

# `Route Post Create`

- **Post**
    - localhost:8000/api/post
    - Body
        
        `{`
        
        `“description” : “test”,`
        
        `}`
        
    - Retorno
        
        `{
            "id": 31,
            "description": "test", 
            "user": [
                {
                    "id": 11,
                    "name": "iago",
                    "email": "[iago@gmail.com](mailto:iago@gmail.com)"
                }
            ]
        }`
        
    

# `Route Post Update`

- **Put**
    - localhost:8000/api/post/{id}
    - Body
        
        `{`
        
        `“description” : “test update”,`
        
        `}`
        
    - Retorno
        
        `{
            "id": 31,
            "description": "test update", 
            "user": [
                {
                    "id": 11,
                    "name": "iago",
                    "email": "[iago@gmail.com](mailto:iago@gmail.com)"
                }
            ]
        }`
        
    

# `Route Post Delete`

- **Delete**
    - localhost:8000/api/post/{id}
    - Body
    - Retorno
        
        `{
            “mensagem” : “Deletado com sucesso”
        }`
        
    

# `Route Comment Create`

- **Post**
    - localhost:8000/api/comment
    - Body
        
        `{`
        
        `“post_id”: 2,`
        
        `“description”: “teste”`
        
        `}`
        
    - Retorno
        
        `{`
        
        `“mensagem”: “Comentario criado.”`
        
        `}`
        

# `Route Like Create`

- **Post**
    - localhost:8000/api/comment
    - Body
        
        `{`
        
        `“post_id”: 2,`
        
        `“like_reaction”: “love”`
        
        `}`
        
    - Retorno