<div align="center">
  <a href="">
    <img src="https://github.com/juletopi/Front-End_Learning_Journey/assets/76459155/4a338377-4c4d-432a-88ab-c7624c0e3c03" alt="HowToContribute-pic" width="124px" title="Veja como contribuir para este repositório!">
  </a>
  <h2 align="center">Como Contribuir</h2>
</div>

<div align="center">
  
  Quer contribuir para este repositório de alguma forma? \
  Veja abaixo as diferentes formas de como você pode fazer isso! <br><br>
  
</div>

<br>

<table align="center">
  <tr>
    <td>
      <h3 align="center">Antes de continuar...</h3>
      <p align="center">
        <a href="">
          <img src="https://media3.giphy.com/media/v1.Y2lkPTc5MGI3NjExNnlveWlha3pxNnV0MThuMTNiYmFldnAwMDQ4ancyeGMzMWR4NmlzYiZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9cw/Qxk537vQtg5QPhSVW6/giphy.gif" alt="Important-gif" width="230px" title="Atenção aos requisitos!">
        </a>
      </p>
      <br>
      <p align="center"><strong>
        Para contribuir com este projeto, você precisará:
      </strong></p>
      <br>
      <div style="display: flex; justify-content: center;">
        <ul style="text-align: left; display: inline-block;">
          <strong>
            <li>Conta no GitHub</li>
            <li>Conhecimento básico de Git (<code>fork</code>, <code>clone</code>, <code>commit</code>, <code>push</code>)</li>
            <li>Para contribuições de código: ambiente PHP/Laravel configurado</li>
            <li>Para contribuições de tradução: fluência no idioma de destino</li>
            <li>Padronização de mensagens de commit seguindo<br><a href="https://www.conventionalcommits.org/en/v1.0.0/">Conventional Commits</a>: <code>feat</code>, <code>fix</code>, <code>add</code>, <code>trans</code>, etc.</li>
          </strong>
          <br>
        </ul>
      </div>
    </td>
  </tr>
</table>

<br>

## Encontrou um bug?

Antes de continuar, certifique-se de que o bug que você encontrou ainda não foi relatado na sessão [Issues](https://github.com/juletopi/PontuaDev_Project/issues) deste repositório.

- Se um bug NÃO estiver mencionado nas [Issues](https://github.com/juletopi/PontuaDev_Project/issues), abra uma nova. Certifique-se de incluir um título, uma descrição clara do comportamento esperado que não está ocorrendo.
> [!TIP]\
> Evite abrir issues pedindo para ser ativamente "atribuído" a uma parte específica do código. Apenas relate o bug.

<br>

## Deseja que uma nova funcionalidade seja adicionada?

Para sugerir ou implementar uma nova funcionalidade:

1. **Proponha a ideia**
   - Abra uma nova [Issue](https://github.com/juletopi/PontuaDev_Project/issues)
   - Descreva o que a funcionalidade deve fazer
   - Se possível, inclua casos de uso ou exemplos de implementação

2. **Implementação (opcional)**
   - Após feedback positivo na issue, você mesmo pode implementar a funcionalidade
   - Siga o mesmo fluxo descrito na seção [Deseja contribuir com código?](#deseja-contribuir-com-código)

<br>

## Deseja contribuir com a documentação?

Caso tenha achado erros de digitação/formatação ou deseja melhorar a documentação:

1. **Fork e Clone**
   - Faça um fork do [repositório](https://github.com/juletopi/PontuaDev_Project)
   - Clone seu fork: `git clone https://github.com/SEU-USUARIO/PontuaDev_Project.git`

2. **Faça as alterações necessárias**
   - Crie uma branch: `git checkout -b doc-SEU-NOME`, por exemplo, `doc-gabriela`.
   - Concentre-se em melhorar a clareza, corrigir erros ou adicionar informações úteis

3. **Envie suas alterações**
   - Commit e push: `git commit -m "Docs corrigido links externos" && git push origin doc-SEU-NOME`
   - Abra um Pull Request da sua branch com a branch `master` do repositório original
   - Aguarde a revisão para aprovação das suas mudanças.

<br>

## Deseja traduzir a documentação?

Para adicionar uma nova tradução ao projeto:

1. **Fork e Clone**
   - Faça um fork do [repositório](https://github.com/juletopi/PontuaDev_Project)
   - Clone seu fork: `git clone https://github.com/SEU-USUARIO/PontuaDev_Project.git`

2. **Crie os arquivos de tradução**
   - Crie uma branch: `git checkout -b traducao-SEU-NOME`, por exemplo, `traducao-thiago`.
   - Adicione seus arquivos na pasta `docs/translations/` seguindo estas diretrizes:
     - Use o padrão `README.[código do idioma].md` (ex: `README.en.md`)
     - Use o código de idioma de duas letras conforme ISO 639-1
     - Mantenha a mesma estrutura e formatação do README original

3. **Envie sua tradução**
   - Commit e push: `git commit -m "Trans adicionada tradução para [IDIOMA]" && git push origin traducao-SEU-NOME`
   - Abra um Pull Request da sua branch com a branch `master` do repositório original
   - Aguarde a revisão para aprovação das suas mudanças.

<br>

## Deseja contribuir com código?

Seja corrigindo um bug ou criando uma nova feature, para contribuir com código para o projeto, siga o fluxo padrão de GitHub:

1. **Fork e Clone**
   - Faça um fork do [repositório](https://github.com/juletopi/PontuaDev_Project)
   - Clone seu fork: `git clone https://github.com/SEU-USUARIO/PontuaDev_Project.git`

2. **Prepare seu ambiente**
   - Crie uma branch para sua alteração: `git checkout -b ajustes-SEU-NOME`, por exemplo `ajustes-joao`.
   - Configure o ambiente Laravel:
     ```bash
     composer install && npm install
     cp .env.example .env && php artisan key:generate
     ```

3. **Desenvolva e teste**
   - Implemente suas alterações seguindo os padrões do projeto
   - Certifique-se que os testes passam: `php artisan test`

4. **Envie sua contribuição**
   - Commit e push: `git commit -m "Fix problema de responsividade X" && git push origin ajustes-SEU-NOME`
   - Abra um Pull Request da sua branch com a branch `master` do repositório original
   - Aguarde a revisão para aprovação das suas mudanças.

> [!IMPORTANT]
> Mantenha sua branch atualizada com o repositório principal antes de criar o Pull Request:
> ```bash
> git remote add upstream https://github.com/juletopi/PontuaDev_Project.git
> git fetch upstream && git rebase upstream/master
> ```

<br>

## Tem alguma pergunta que deseja fazer?

- Faça qualquer pergunta sobre o repositório abrindo uma nova<br>discussão na sessão de [Discussions](https://github.com/juletopi/PontuaDev_Project/discussions) deste repositório.

<br>

---

<br>

<table align="center">
  <tr>
    <td>
      <p align="center">
        <strong>
            <div align="center">
              E isso é tudo! <br><br>
              Sinta-se livre para contribuir ou discutir sobre este repositório. <br>
              Obrigado pela sua atenção!
            </div>
        </strong>
      </p>
      <p align="center">
        <a href="">
          <img src="https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExeW95Y2JqdXY5emlwanZ0ajlxYjdsZW9zMXNlYWt1bXRyNWtzcWY3cSZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9cw/FJxz3zSthG5vQxG1ZY/giphy.gif" alt="Byebye-gif" width="200px" title="Tchau tchau!">
        </a>
      </p>
    </td>
  </tr>
</table>
