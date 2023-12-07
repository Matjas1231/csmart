Aby uruchomić aplikację należy:

1. Utworzyć bazę danych (schemat znajduje się w pliku `db_schema.db`)
1. Wpisać komendę: composer install (composer jest używany tylko do autoload, niewykorzystywane są żadne zewnętrzne biblioteki)
1. Wpisać komendę: php -S 127.0.0.1:8000 -t public

---

Schemat bazy danych znajduje się w pliku `db_schema.db`. Połączenie do bazy można zmienić w pliku `app\Core\config.php`.

Myślę, że podpunkty zadania zostały zrealizowane (dodawanie i edycja kont/faktur/produktów na fakturze) oraz został dodany raport, w którym można filtrować faktury po dacie.

Do lekkiego wystylizowania aplikacji użyłem `Bootstrap`.

Do działań na bazie używałem dostarczonej klasy, jednak zmieniłem nazwę pliku na `Db.php`, znajduje się pod tą ścieżką `app\Core\Db.php`.

Na pewno do poprawy jest walidacja danych oraz organizacja kodu JS.
