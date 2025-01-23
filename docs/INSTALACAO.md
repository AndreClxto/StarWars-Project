# Instruções de Instalação

Siga as etapas abaixo para configurar o projeto no seu ambiente local.

## Requisitos

Antes de iniciar a instalação, verifique se você tem os seguintes requisitos:

- **PHP**: 7.4 ou superior.
- **Servidor Web**: Apache ou Nginx.
- **Banco de Dados**: MySQL ou MariaDB.
- **cURL**: Para realizar requisições à API externa.
- **Composer**: Para gerenciamento de dependências PHP.

## Passos para Instalação

1. **Clonar o Repositório**

   Primeiro, clone o repositório para o seu ambiente local. Se estiver usando o XAMPP, por exemplo, copie para a pasta htdocs

2. **Configurar o Banco de Dados**

    - Crie um banco de dados MySQL chamado starwarsdb
    - Importe o dump do banco de dados que está incluído na pasta banco-de-dados/ para criar as tabelas necessárias

3. **Configuração do Arquivo de Banco de Dados**

    No código, as configurações de banco de dados são definidas na classe DataBaseHandler.php, e existem objetos dessa classe nos arquivos: routes.php e MovieController.php. Certifique-se de que as credenciais do banco de dados estejam corretas:

    $dbHandler = new DataBaseHandler('localhost', 'starwarsdb', 'root', '');

    Se necessário, altere o host, usuário ou senha para o seu ambiente.

4. **Acesse o projeto pelo link index.php**

    Insira o endereço correto no navegador, por exemplo:

    http://localhost/starwars_project/src/index.php