# MIRJAN24

Co robi moduł?

1. W __construct deklaruję podstawowe informację o module takie jak jego nazwa, wersja, autora, wspierane wersje Presty

2. Metodą instalacji Install rejestruję hook 'displayHome', który będzie wywoływany podczas wyświetlania strony głównej.

3. Następnie wywołuję metodą deinstalacji 'uninstall', aby wykonały sie standardzowe działania w momencie odinstalowania modułu 

4. W funkcji hookDisplayHome
   a) pobieram wartości dla $taskContent z klasy Configuration
   b) podpinam plik CSS
   c) przekazuję $taskContent do szablonu po w celu wyświetlenia danych w formie HTML

5. W 'getContent' sprawdzam czy formularz został konfiguracyjny wysłany, po czym pobieram dane z formularza

6. Za pomocą renderForm tworze formularz konfiguracyjny modułu zapomocą którego wprowadzam danę wyświetlanę pożniej przez moduł

7. W szablonie .tpl sprawdzam czy $taskContent posiada