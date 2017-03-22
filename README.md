# Braspag API SDK (NÃO OFICIAL)

Repositório oficial:
 https://github.com/Braspag/BraspagApiPhpSdk
 
Repositório criado a partir da versão v2.0 para sanar problemas pontuais que levariam algumas semanas para ser aceito o PR.

## Principais recursos

* [x] Pagamentos por cartão de crédito. (tested)
* [x] Cancelamento de autorização. (tested)
* [x] Consulta de pagamentos. (tested)
* [x] Captura de pagamentos. (tested)
* [x] Pagamentos recorrentes. (not tested)
    * [x] Com autorização na primeira recorrência.
    * [x] Com autorização a partir da primeira recorrência.
* [x] Pagamentos por cartão de débito. (not tested)
* [x] Pagamentos por boleto. (not tested)
* [x] Pagamentos por transferência eletrônica. (not tested)
 
## Limitações

Por envolver a interface de usuário da aplicação, o SDK funciona apenas como um framework para criação das transações. Nos casos onde a autorização é direta, não há limitação; mas nos casos onde é necessário a autenticação ou qualquer tipo de redirecionamento do usuário, o desenvolvedor deverá utilizar o SDK para gerar o pagamento e, com o link retornado pela Cielo, providenciar o redirecionamento do usuário.

### Criando um pagamento com cartão de crédito
 Ver:
 - tests/SimpleExamplesTest.php
 - tests/BDD/AuthorizationTest.php
 - tests/BDD/CancelationTest.php
 - tests/BDD/CaptureTest.php
 - tests/BDD/SearchPaymentTest.php

