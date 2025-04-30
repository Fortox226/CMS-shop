#  CMS Articles – system zarządzania treścią

Lekki system CMS oparty na PHP do zarządzania artykułami. Umożliwia dodawanie, edytowanie, usuwanie oraz wyświetlanie treści, z możliwością logowania i rejestracji użytkowników.

##  Działanie plików w `php/`

| Plik                  | Opis                                                                 |
|-----------------------|----------------------------------------------------------------------|
| `index.php`           | Główna strona serwisu. Może wyświetlać listę artykułów lub stronę powitalną. |
| `login.php`           | Formularz logowania. Sprawdza dane i tworzy sesję po poprawnym logowaniu. |
| `register.php`        | Formularz rejestracyjny. Dodaje nowego użytkownika do bazy danych.   |
| `logout.php`          | Wylogowuje użytkownika i niszczy jego sesję.                         |
| `admin.php`           | Panel administracyjny (widoczny po zalogowaniu). Pozwala zarządzać użytkownikami. |
| `article.php`         | Wyświetla pojedynczy artykuł na podstawie ID z URL.                  |
| `edit.php`            | Formularz edycji istniejącego artykułu lub dodania nowego.           |
| `delete.php`          | Usuwa wskazany artykuł z bazy i (opcjonalnie) jego obrazek z serwera. |
| `update.php`          | Obsługuje zapis zmian artykułu (formularz z `edit.php`).             |
| `config.php`          | Ustawienia bazy danych i połączenia (`PDO` lub `mysqli`).            |
---

##  Funkcje CMS-a

-  Rejestracja i logowanie użytkowników
-  Autoryzacja z wykorzystaniem sesji
-  Panel administratora
-  Dodawanie artykułów z obrazkiem
-  Edycja i usuwanie artykułów
-  Upload plików do katalogu `uploads/`
-  Wyświetlanie pojedynczych artykułów

---

##  Uruchomienie lokalne (XAMPP)

1. Skopiuj folder `CMS-SHOP/` do `C:/xampp/htdocs/`.
2. W przeglądarce przejdź do:


3. Załaduj bazę danych z pliku `cms.sql` w phpMyAdmin.

---

##  Wymagania

- PHP 7.4 lub wyższy
- Apache (XAMPP, Laragon, itp.)
- MySQL lub MariaDB
- (Opcjonalnie) Kompilator SCSS (np. Live Sass Compiler)

---

##  Uwagi

- Brak systemu routingu – każda strona to osobny plik PHP.
- Użytkownik porusza się po stronie przez konkretne ścieżki, np. `/login.php`, `/admin.php`, itd.
- Stylowanie w SCSS → kompilowane do `css/`.

---

##  Licencja

MIT – możesz dowolnie używać, kopiować, modyfikować.

---

##  Autor

*Imię lub pseudonim autora projektu*




