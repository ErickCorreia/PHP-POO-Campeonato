# ⚽ CRUD Campeonato Brasileiro — PHP & PDO

Projeto de um sistema web para gerenciamento de times de futebol, desenvolvido como atividade prática para o **4º semestre do curso de Análise e Desenvolvimento de Sistemas (ADS)**.

O sistema implementa as operações fundamentais de um **CRUD (Create, Read, Update, Delete)** utilizando **PHP Orientado a Objetos** e comunicação segura com o banco de dados por meio do **PDO**, apresentando uma interface temática inspirada no Campeonato Brasileiro.

---

## 🚀 Tecnologias Utilizadas

- **Linguagem:** PHP 8+ (Orientação a Objetos e PDO)
- **Banco de Dados:** MySQL
- **Front-end:** HTML5, CSS3 (Flexbox)
- **Ícones:** FontAwesome v6.4.0

---

## ⚙️ Funcionalidades

- **Cadastro de Times:** inserção de nome, cor principal (via *color picker* nativo), ano de fundação e nome do presidente.
- **Listagem Dinâmica:** exibição dos times em uma tabela, com visualização em tempo real das cores e ícones customizados.
- **Atualização de Dados:** edição dos dados existentes diretamente pela interface.
- **Exclusão Segura:** remoção de registros com caixa de confirmação utilizando JavaScript.
- **Arquitetura Limpa:** separação da regra de negócio, representada pela classe `Time`, da camada de apresentação, representada pelo `index.php`.

---

## 📂 Estrutura do Projeto

```text
campeonato/
│
├── Time.php       # Classe com os métodos CRUD
├── index.php      # Interface do usuário e rotas de formulários/ações
└── README.md      # Documentação do projeto
````

---

 ## 📋 Pré-requisitos

 Para executar este projeto localmente, você precisará de um ambiente de desenvolvimento web completo contendo:

 - Apache
- PHP 8+
- MySQL

 Recomenda-se o uso de uma das seguintes ferramentas:

 - XAMPP
- WAMP Server
- Laragon

---

 ## 🔧 Passo a Passo para Execução

 ### 1\. Clonar o Repositório

 Navegue até a pasta pública do seu servidor local pelo terminal.

 Exemplos:

 - `htdocs` no XAMPP
- `www` no WAMP
- Diretório correspondente do Laragon

 Depois, execute:

```
git clone https://github.com/SEU_USUARIO/SEU_REPOSITORIO.git
```

 > **Observação:** substitua `SEU_USUARIO` e `SEU_REPOSITORIO` pelas informações reais do seu repositório.

 Caso não utilize o Git, faça o download do código como **ZIP** e extraia a pasta dentro do diretório público do seu servidor local.

---

 ### 2\. Configurar o Banco de Dados

 Inicie os serviços do **Apache** e **MySQL** no painel de controle da sua ferramenta de desenvolvimento.

 Por exemplo, no XAMPP, abra o **XAMPP Control Panel** e inicie os serviços necessários.

 Em seguida, acesse o **phpMyAdmin** pelo navegador:

```
http://localhost/phpmyadmin
```

 Acesse a aba **SQL** e execute o código abaixo:

```
CREATE DATABASE campeonato;

USE campeonato;

CREATE TABLE time (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cor VARCHAR(50) NOT NULL,
    ano INT NOT NULL,
    presidente VARCHAR(100) NOT NULL
);
```

 Esse código irá:

 1. Criar o banco de dados `campeonato`;
2. Selecionar o banco de dados criado;
3. Criar a tabela `time`;
4. Definir os campos necessários para o cadastro dos times.

---

 ### 3\. Ajustar as Credenciais de Conexão

 Por padrão, o projeto utiliza o usuário `root` e uma senha vazia para a conexão com o MySQL.

 Caso o seu MySQL utilize uma senha ou um usuário diferente, abra o arquivo `index.php` e ajuste as variáveis de conexão:

```
$host = 'localhost';
$db_name = 'campeonato';
$username = 'root'; // Insira o seu usuário do MySQL
$password = '';     // Insira a sua senha do MySQL
```

 > **Importante:** verifique se essas informações correspondem às credenciais configuradas no seu ambiente MySQL.

---

 ### 4\. Executar a Aplicação

 Após configurar o servidor e o banco de dados, abra o navegador e acesse:

```
http://localhost/SEU_REPOSITORIO
```

 Substitua `SEU_REPOSITORIO` pelo nome exato da pasta do projeto dentro do diretório público do seu servidor local.

 Por exemplo:

```
http://localhost/campeonato
```

---

 ## 📁 Organização do Projeto

 | Arquivo | Descrição |
| --- | --- |
| `Time.php` | Contém a classe responsável pelas operações do CRUD. |
| `index.php` | Contém a interface do usuário, formulários e execução das ações. |
| `README.md` | Contém a documentação e instruções para execução do projeto. |

---

 ## 🛠️ Operações CRUD

 O projeto implementa as quatro operações fundamentais de um CRUD:

 | Operação | Descrição |
| --- | --- |
| **Create** | Cadastra novos times no banco de dados. |
| **Read** | Lista os times cadastrados. |
| **Update** | Atualiza os dados de um time existente. |
| **Delete** | Exclui um time do banco de dados. |

---

 ## 👤 Autor

 **Desenvolvido por:** \[Erick Correia Coelho\]

 **Curso:** Análise e Desenvolvimento de Sistemas (ADS)\
 **Semestre:** 4º Semestre
