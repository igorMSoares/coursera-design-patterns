# Desenvolvimento Ágil com Padrões de Projeto

## Projeto Final

O objetivo dessa tarefa é fazer um componente de gamificação, que armazena diferentes tipos de conquista de um determinado usuário do sistema.

Para implementar esse componente, a especificação lista alguns padrões de projeto vistos no curso que precisam ser utilizados. Pede-se também a implementação de um pequeno exemplo para o uso e teste do componente.

## Design Patterns Utilizados

### Singleton

Só pode haver uma única instância de `AchievementStorage` em toda aplicação.

### Decorator

Classes que implementam `ForumService` podem ter funcionalidades adicionais, como adicionar novos `Achievement`, através do decorator.

### Observer

`AchievementStorage` pode adicionar `AchievementObserver` para disparar ações de acordo com o estado dos `Achievement` armazenados, como por exemplo atribuir um badge quando um determinado `Achievement` atingir um certo número de pontos.

### Null Object

Se um `Achievement` não for econtrado em `AchievementStorage`, `getAchievement()` retornará um `NullAchievement`, um tipo especial que indica a não existência de um `Achievement`.

## Testes

Os seguintes testes foram implementados:

- Chamar o método `addTopic()` e verificar se os achievements foram adicionados da forma correta.

- Chamar o método `addComment()` e verificar se os achievements foram adicionados da forma correta.

- Chamar o método `likeTopic()` e verificar se os achievements foram adicionados da forma correta.

- Chamar o método `likeComment()` e verificar se os achievements foram adicionados da forma correta.

- Chamar o método `addTopic()` duas vezes e verificar se os pontos foram somados e se o badge está presente apenas uma vez.

- Invocar vários métodos e verificar se o resultado é o esperado.

- Fazer o `ForumServiceGamification` mock lançar uma exceção para algum método e verificar se os `Achievement` não foram adicionados.

- Atingir 100 pontos de _"CREATION"_ e verificar se o usuário recebe o badge _"INVENTOR"_.

- Atingir 100 pontos de _"PARTICIPATION"_ e verificar se o usuário recebe o badge _"PART OF THE COMMUNITY"_.

### PHPUnit Screenshot

![PHPUnit Screenshot](https://igormsoares.github.io/public/examples/design-patterns-phpunit-tests.png)

## Exemplo de Uso

O script `main.php` simula um exemplo de como as classes seriam utilizadas em uma aplicação.
São disparadas aleatoriamente ações do `ForumServiceGamificationProxy` (`addTopic()`, `addComent()`, `likeTopic()`, `likeComment()`) num total de 100 vezes e ao final será exibido no terminal o estado do `AchievementStorage`.

![main.php output screenshot](https://igormsoares.github.io/public/examples/design-patterns-main-script.png)

## Instalação

Necessário PHP8 e Composer instalados.
Para rodar o exemplo ou os testes, clone o projeto e na pasta raiz do projeto rode:

```bash
composer install # Instala as dependencias
php main.php # Roda o exemplo
composer test # Roda os testes
```
