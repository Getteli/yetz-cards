## Teste Yetz Cards

O projeto possui docker mas pode ser iniciado diretamente pelo serve do artisan.

Link do projeto no ar: https://yetz-cards.onrender.com/

Preencha os dados no .env local para criar o banco e dados

Rode o seed para ter uma base de teste
### Seed
```bash
php artisan migrate --seed
```

### Formas de iniciar o projeto

### Docker

```bash
// construir a imagem
docker build -t yetzcardsdocker . 

// iniciar o container
docker run -p 80:80 yetzcardsdocker
```

### Artisan
```bash
php artisan serve
```

Alguns pontos:
- Decidi adicionar um diagrama de entidade relaciomento para facilitar a visualização da modelagem do banco usando o **[mermaid](https://mermaid.js.org/)**;

- Coloquei o projeto no ar pelo **[render](https://render.com/)** e o banco em um droplet da digital ocean;

- O projeto roda no docker usando o nginx;

- O projeto esta no ar no render usando o docker;

- O metodo que utlizei para escolher o peso dos jogadores para equilibrar o time foi ordenar de forma que a escolha seja feita com 1 de maior nível e um de menor nível, de forma intercalada, evitando assim times muito fortes e muito fracos;

- Utilizei a autenticação para o usuário que controlará o CRUD do sistema;

- O site possui um seed para começar os testes;

- O site está responsivo;

- UTilizei o framework **[tailwindcss](https://tailwindcss.com/)** paa o front;