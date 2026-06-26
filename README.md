# Super 8 Beach Tennis

Sistema web desenvolvido para facilitar a organização de torneios de Beach Tennis, automatizando o cadastro de participantes, geração de duplas, criação de rodadas, registro de resultados e atualização da classificação.

##Sobre o projeto

O **Super 8 Beach Tennis** foi desenvolvido com o objetivo de reduzir o trabalho manual dos organizadores de torneios, oferecendo uma plataforma simples e intuitiva para gerenciar competições.

O sistema possui dois formatos de competição:

- Duplas Rotativas: as duplas são formadas automaticamente pelo sistema, promovendo maior interação entre os participantes.
- Duplas Fixas: o organizador define previamente as duplas, que permanecem as mesmas durante todo o torneio.

Além disso, o sistema permite registrar e editar resultados, atualizando automaticamente a classificação.

---

## Funcionalidades

- Cadastro de participantes
- Configuração do torneio
- Geração automática de duplas rotativas
- Cadastro de duplas fixas
- Geração automática das rodadas
- Registro de resultados
- Edição de placares
- Validação para impedir empates
- Atualização automática da classificação
- Classificação individual (Duplas Rotativas)
- Classificação por dupla (Duplas Fixas)
- Armazenamento dos dados em arquivos JSON

---

## Tecnologias utilizadas

- HTML
- CSS
- JavaScript
- PHP
- JSON

---

## Estrutura do projeto

```
Super-8-Beach-Tennis/
│
├── classificacao/           
├── configuracao/      
├── css/     
├── data/          
├── js/            
├── participantes/
├── rodadas/
├── utils/             
├── index.php         
└── README.md
```


## Funcionalidades do sistema

- Cadastro de participantes
- Configuração do torneio
- Geração automática das rodadas
- Gerenciamento de partidas
- Atualização automática da classificação
- Suporte aos formatos de Duplas Rotativas e Duplas Fixas

---

## Regras implementadas

- Não permite empates nas partidas.
- Permite editar o resultado de qualquer jogo.
- Atualiza automaticamente a classificação após alterações no placar.
- Organiza automaticamente os confrontos.
- Classificação individual no modo Duplas Rotativas.
- Classificação por equipe no modo Duplas Fixas.

---

## Objetivo

O projeto foi desenvolvido como trabalho acadêmico com foco na automação da organização de torneios de Beach Tennis, oferecendo uma solução prática para cadastro de participantes, geração de confrontos, controle de resultados e classificação em tempo real.

---

## Autor

Klesly Rocha

Projeto desenvolvido para fins acadêmicos.
