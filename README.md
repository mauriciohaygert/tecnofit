O repositório [mauriciohaygert/tecnofit](https://github.com/mauriciohaygert/tecnofit) implementa o desafio técnico de ranking de movimentos utilizando PHP puro e MySQL, conforme solicitado.

### 📁 Estrutura do Projeto

* **`src/`**: Contém os arquivos principais do código-fonte.
* **`config/`**: Arquivos da injeção de dependência, carragamento do .env, e rotas.
* **`public/`**: Diretório público, contem o ponto de entrada da aplicação.
* **`docker/`**: Configurações do Docker.
* **`docker-compose.yml`**: Arquivo para orquestração dos serviços Docker.
* **`.env`**: Variáveis de ambiente, como credenciais do banco de dados.
* **`README.md`**: Arquivo gerado pelo ChatGPT 

### 🚀 Como Executar o Projeto

1. **Clonar o repositório:**

   ```
   git clone https://github.com/mauriciohaygert/tecnofit.git
   cd tecnofit
   ```

2. **Configurar variáveis de ambiente:**
   O arquivo `.env` está no reposítório para facilitar a execução do docker, em circustancias reais isto não deve ser feito.

3. **Iniciar os serviços com Docker:**

   ```
   docker-compose up -d
   ```

4. **Acessar o endpoint de ranking:**
   Após os serviços estarem em execução, você pode acessar o endpoint de ranking através de:

   ```
   http://localhost:8000/ranking/movement/{nome}
   ```

   Substitua `{nome}` pelo nome do movimento desejado, como `Deadlift`.
