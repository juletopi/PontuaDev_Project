<!--
References used in this Repository
https://github.com/kyechan99/capsule-render
https://github.com/DenverCoder1/custom-icon-badges
https://github.com/alexandresanlim/Badges4-README.md-Profile
https://shields.io
https://getemoji.com
-->

<!-- PRESENTATION -->

<div align="center">
  <a href="">
    <img src="public/img/PontuaDev.svg" alt="PontuaDev-Logo" width="160px" title="Sistema de Gerenciamento de Desenvolvedores">
  </a>
  <h2 align="center">PontuaDev</h2>
</div>

<div align="center">
 
  • Sistema para gerenciar e pontuar desenvolvedores e suas tarefas.
 
</div>

<div align="center">
    <a href="https://laravel.com/">
        <img src="https://img.shields.io/badge/Made%20with%20framework:-Laravel%2012%20-gray.svg?colorA=EA5151&amp;colorB=FF2D20&amp;style=for-the-badge" alt="Laravel-badge" style="max-width: 100%;">
    </a>
    <a href="https://www.php.net/">
        <img src="https://img.shields.io/badge/Made%20with%20language:-PHP%208.2%20-gray.svg?colorA=8C96C6&amp;colorB=777BB4&amp;style=for-the-badge" alt="PHP-badge" style="max-width: 100%;">
    </a>
</div>

<div align="center">
    <a href="https://getbootstrap.com/">
        <img src="https://img.shields.io/badge/Made%20with%20library:-Bootstrap%204.5%20-gray.svg?colorA=9B7AD5&amp;colorB=7952B3&amp;style=for-the-badge" alt="Bootstrap-badge" style="max-width: 100%;">
    </a>
    <a href="https://jquery.com/">
        <img src="https://img.shields.io/badge/Made%20with%20library:-jQuery%203.5%20-gray.svg?colorA=2B90D9&amp;colorB=0769AD&amp;style=for-the-badge" alt="jQuery-badge" style="max-width: 100%;">
    </a>
</div>

<br>

<div align="center">
  <a href="#-requisitos">Requisitos</a> &#xa0; • &#xa0;
  <a href="#-tecnologias-utilizadas">Tecnologias</a> &#xa0; • &#xa0;
  <a href="#-instalação">Instalação</a> &#xa0; • &#xa0;
  <a href="#-licença">Licença</a>
</div>

<!-- ABOUT THE PROJECT -->

## 📝 Sobre o Projeto

O **PontuaDev** é um sistema de gerenciamento para equipes de desenvolvimento, permitindo:

- Cadastro de desenvolvedores com informações detalhadas
- Gerenciamento de tarefas com atribuição de pontos
- Sistema de acompanhamento de desempenho
- Gerenciamento de prazos e entregas

<div align="left">
  <h6><a href="#pontuadev"> Voltar para o início ↺</a></h6>
</div>

## 📋 Requisitos

> [!IMPORTANT]  
> Certifique-se de ter os seguintes requisitos antes de iniciar:

<a href="https://www.php.net/">
  <img src="https://img.shields.io/badge/PHP-8.2_ou_superior-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP-badge">
</a>
<a href="https://getcomposer.org/">
  <img src="https://img.shields.io/badge/Composer-2.0_ou_superior-885630?style=for-the-badge&logo=composer&logoColor=white" alt="Composer-badge">
</a>
<a href="https://www.postgresql.org/">
  <img src="https://img.shields.io/badge/PostgreSQL-4169E1?style=for-the-badge&logo=postgresql&logoColor=white" alt="PostgreSQL-badge">
</a>

<div align="left">
  <h6><a href="#pontuadev"> Voltar para o início ↺</a></h6>
</div>

## 💻 Tecnologias Utilizadas

<a href="https://laravel.com/">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel-badge">
</a>
<a href="https://getbootstrap.com/">
  <img src="https://img.shields.io/badge/Bootstrap-4.5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap-badge">
</a>
<a href="https://icons.getbootstrap.com/">
  <img src="https://img.shields.io/badge/Bootstrap_Icons-1.11-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap-Icons-badge">
</a>
<a href="https://jquery.com/">
  <img src="https://img.shields.io/badge/jQuery-3.5-0769AD?style=for-the-badge&logo=jquery&logoColor=white" alt="jQuery-badge">
</a>

<div align="left">
  <h6><a href="#pontuadev"> Voltar para o início ↺</a></h6>
</div>

## 🚀 Instalação

1. Clone o repositório
```bash
git clone https://github.com/seu-usuario/pontuadev.git
cd pontuadev
```

2. Instale as dependências do PHP
```bash
composer install
```

3. Copie o arquivo de ambiente
```bash
cp .env.example .env
```

4. Configure o banco de dados no arquivo `.env`

> [!NOTE]  
> Você pode escolher entre PostgreSQL (recomendado para produção) ou SQLite (mais simples para testes).

Opção com PostgreSQL:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=pontuaDev
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

Opção alternativa com SQLite (mais simples para testes):
```
DB_CONNECTION=sqlite
DB_DATABASE=/caminho/absoluto/para/database.sqlite
```

Se escolher SQLite, crie o arquivo vazio com o comando:
```bash
touch database/database.sqlite
```

5. Gere a chave da aplicação
```bash
php artisan key:generate
```

6. Execute as migrations para criar as tabelas do banco de dados
```bash
php artisan migrate
```

> [!TIP]  
> Opcionalmente, você pode popular o banco com dados de exemplo:
> ```bash
> php artisan db:seed
> ```
> Ou fazer ambos em um único comando:
> ```bash
> php artisan migrate --seed
> ```

7. Inicie o servidor
```bash
php artisan serve
```

<div align="left">
  <h6><a href="#pontuadev"> Voltar para o início ↺</a></h6>
</div>

## 📝 Licença

Este projeto está licenciado sob uma licença personalizada que permite uso e modificação privada, mas **proíbe uso comercial**. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

Para uso comercial deste software, entre em contato com o autor em juliocezarpvh@hotmail.com para obter uma licença comercial.

<div align="left">
  <h6><a href="#pontuadev"> Voltar para o início ↺</a></h6>
</div>

<br>

<!-- AUTHOR -->

## 👤 Autor

<table>
  <tr>
    <td valign="middle" width="25%">
      <div align="center">  
        <a href="https://github.com/juletopi" title="Perfil no GitHub" aria-label="GitHub - Juletopi">
          <img src="https://avatars.githubusercontent.com/u/76459155?s=400&u=4b9bd87cae92eea4fc154c28eafe226ed034a1d8&v=4" width="150" alt="Profile Pic - Juletopi"/>
          <br>
          <sub><strong>Júlio Cézar | Juletopi</strong></sub>
          <br>
        </a>
      </div>
    </td>
    <td valign="middle" width="75%">
      <ul style="list-style: none; padding-left: 0; margin: 0;">
        <li>
          <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/linkedin/linkedin-original.svg" width="15" alt="LinkedIn" style="vertical-align:middle;">
          LinkedIn — 
          <a href="https://www.linkedin.com/in/julio-cezar-pereira-camargo/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn - Júlio Cézar P. Camargo">
            Júlio Cézar P. Camargo
          </a>
        </li>
        <li>
          <img src="https://pngimg.com/uploads/email/email_PNG100738.png" width="15" alt="Email" style="vertical-align:middle;">
          Email — 
          <a href="mailto:juliocezarpvh@hotmail.com" aria-label="Send email - juliocezarpvh@hotmail.com">
            juliocezarpvh@hotmail.com
          </a>
        </li>
        <li>
          <img src="https://cdn3.emoji.gg/emojis/2116-facebook.png" width="15" alt="Facebook" style="vertical-align:middle;">
          Facebook — 
          <a href="https://www.facebook.com/juhletopi" target="_blank" rel="noopener noreferrer" aria-label="Facebook - Juhletopi">
            facebook.com/juhletopi
          </a>
        </li>
        <li>
          <img src="https://cdn3.emoji.gg/emojis/6333-instagram.png" width="15" alt="Instagram" style="vertical-align:middle;">
          Instagram — 
          <a href="https://www.instagram.com/juletopi/" target="_blank" rel="noopener noreferrer" aria-label="Instagram - Juletopi">
            @juletopi
          </a>
        </li>
      </ul>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <img src="https://juletopi.github.io/JCPC_Portfolio/src/images/initialsLogo.png" width="25" alt="Portfolio" align="center"/>
      Portfolio —
      <a href="https://juletopi.github.io/JCPC_Portfolio/" target="_blank" rel="noopener noreferrer" aria-label="Portfolio - Juletopi">
        juletopi.github.io/JCPC_Portfolio
      </a>
    </td>
  </tr>
</table>

<div align="left">
  <h6><a href="#pontuadev"> Voltar para o início ↺</a></h6>
</div>

<br>

<!-- THANK YOU, GOODBYE -->

----

<div align="center">
  Feito com ❤️ e ☕ por <a href="https://github.com/juletopi"> Juletopi</a>.
</div>
