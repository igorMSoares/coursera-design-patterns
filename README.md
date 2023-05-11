# Desenvolvimento Ágil com Padrões de Projeto

## Projeto Final

O objetivo dessa tarefa é fazer um componente de gamificação, que armazena diferentes tipos de conquista de um determinado usuário do sistema.

Para implementar esse componente, a especificação lista alguns padrões de projeto vistos no curso que precisam ser utilizados. Pede-se também a implementação de um pequeno exemplo para o uso e teste do componente.

## Design Patterns Utilizados

- Singleton
  Só pode haver uma única instância de AchievementStorage em toda aplicação.
- Decorator
  Classes que implementam ForumService podem ter funcionalidades adicionais, como adicionar novos Achievements, através do decorator.
- Observer
  AchievementStorage pode adicionar observers para disparar ações de acordo com o estado dos Achievement armazenados, como por exemplo atribuir um badge quando um determinado Achievement atingir um certo número de pontos.
- Null Object
  Se um Achievement não for econtrado em AchievementStorage, getAchievement() retornará um NullAchievement, um tipo especial que indica a não existência de um Achievement.
