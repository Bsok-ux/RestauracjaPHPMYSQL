# System Zarządzania Restauracją

Prosty system do zarządzania restauracją, napisany w PHP, umożliwiający zarządzanie stolikami, menu oraz zamówieniami.

## Opis Projektu

Aplikacja została stworzona w celu ułatwienia podstawowych operacji w restauracji, takich jak:
*   Rejestrowanie i zarządzanie stolikami (dostępność, pojemność).
*   Tworzenie i zarządzanie menu (kategorie, pozycje, ceny).
*   Przyjmowanie i obsługa zamówień od klientów.
*   Śledzenie statusu zamówień.
*   Podstawowe statystyki dotyczące zamówień.

## Technologie

*   **Backend:** PHP (bez frameworka)
*   **Baza danych:** MySQL / MariaDB
*   **Frontend:** HTML, CSS, Bootstrap (do podstawowej stylizacji)
*   **Serwer WWW:** Apache (np. w XAMPP)

## Instalacja

1.  **Sklonuj repozytorium (lub pobierz pliki projektu):**
    ```bash
    # Jeśli używasz Gita
    # git clone <adres-repozytorium> ./restauracja
    # cd restauracja
    ```
    Jeśli pobrałeś pliki ZIP, rozpakuj je do odpowiedniego folderu na serwerze WWW (np. `htdocs` w XAMPP).

2.  **Baza danych:**
    *   Utwórz nową bazę danych w swoim systemie MySQL/MariaDB (np. przez phpMyAdmin). Zalecana nazwa to `restaurant` (zgodnie z `config/database.php`), ale możesz użyć innej i zaktualizować konfigurację.
    *   Zaimportuj strukturę tabel oraz przykładowe dane z plików `database.sql` oraz `insert_data.sql` (jeśli istnieje i zawiera dane początkowe). Plik `database.sql` powinien zawierać definicje tabel, a `insert_data.sql` przykładowe menu, stoliki itp.

3.  **Konfiguracja:**
    *   Skopiuj plik `config/database.php.example` (jeśli istnieje) do `config/database.php` lub upewnij się, że plik `config/database.php` istnieje.
    *   Otwórz plik `config/database.php` i zaktualizuj dane dostępowe do Twojej bazy danych:
        ```php
        <?php
        return [
            'host' => 'localhost',      // lub adres Twojego serwera bazy danych
            'dbname' => 'restaurant',   // nazwa Twojej bazy danych
            'username' => 'root',       // użytkownik bazy danych
            'password' => '',           // hasło użytkownika bazy danych
            'charset' => 'utf8mb4'
        ];
        ```
    *   Otwórz plik `index.php` i upewnij się, że stała `BASE_URL` jest poprawnie ustawiona dla Twojego środowiska lokalnego. Powinna wskazywać na główny folder projektu na serwerze WWW, np.:
        ```php
        define('BASE_URL', 'http://localhost/restauracja/');
        ```
        Gdzie `restauracja` to nazwa folderu, w którym znajdują się pliki projektu.

## Uruchomienie

1.  Upewnij się, że Twój serwer WWW (np. XAMPP, WAMP) jest uruchomiony i moduły Apache oraz MySQL działają.
2.  Otwórz przeglądarkę internetową i przejdź pod adres zdefiniowany w `BASE_URL` (np. `http://localhost/restauracja/`).

## Struktura Projektu

```
/restauracja/
|-- config/
|   |-- database.php        # Konfiguracja bazy danych
|-- controllers/
|   |-- Controller.php      # Kontroler bazowy
|   |-- HomeController.php  # Kontroler strony głównej
|   |-- MenuController.php  # Kontroler zarządzania menu
|   |-- OrdersController.php# Kontroler zarządzania zamówieniami
|   |-- TablesController.php# Kontroler zarządzania stolikami
|-- models/
|   |-- Model.php           # Model bazowy (obsługa DB)
|   |-- MenuModel.php       # Model dla menu
|   |-- OrderModel.php      # Model dla zamówień
|   |-- TableModel.php      # Model dla stolików
|-- views/
|   |-- home/
|   |   |-- index.php       # Widok strony głównej
|   |-- layouts/
|   |   |-- main.php        # Główny szablon strony (jeśli używany)
|   |   |-- header.php      # Nagłówek (jeśli używany)
|   |   |-- footer.php      # Stopka (jeśli używany)
|   |-- menu/               # Widoki dla menu
|   |-- orders/             # Widoki dla zamówień
|   |-- tables/             # Widoki dla stolików
|-- public/
|   |-- css/                # Pliki CSS
|   |-- js/                 # Pliki JavaScript (jeśli są)
|   |-- images/             # Obrazy (jeśli są)
|-- .htaccess               # Konfiguracja serwera Apache (opcjonalnie, dla ładnych URLi)
|-- index.php               # Główny plik wejściowy (router)
|-- database.sql            # Struktura bazy danych
|-- insert_data.sql         # Przykładowe dane (opcjonalnie)
|-- README.md               # Ten plik
```

## Główne Funkcje

### Zarządzanie Stolikami (`?controller=tables`)
*   Wyświetlanie listy wszystkich stolików wraz z ich statusem (wolny, zajęty, zarezerwowany) i pojemnością.
*   Dodawanie nowych stolików (numer, pojemność).
*   Edycja istniejących stolików.
*   Zmiana statusu stolika.
*   Podgląd szczegółów stolika.
*   Możliwość utworzenia nowego zamówienia dla wolnego stolika bezpośrednio z widoku szczegółów stolika.

### Zarządzanie Menu (`?controller=menu`)
*   Wyświetlanie pozycji menu, pogrupowanych według kategorii.
*   Dodawanie nowych kategorii menu.
*   Dodawanie nowych pozycji do menu (nazwa, opis, cena, kategoria, dostępność).
*   Edycja istniejących pozycji menu.
*   Zarządzanie dostępnością pozycji menu.

### Zarządzanie Zamówieniami (`?controller=orders`)
*   Wyświetlanie listy wszystkich zamówień z możliwością filtrowania po statusie.
*   Tworzenie nowego zamówienia dla wybranego stolika.
*   Dodawanie pozycji z menu do zamówienia, określanie ilości.
*   Wyświetlanie szczegółów zamówienia (numer stolika, lista pozycji, suma, status).
*   Aktualizacja statusu zamówienia (np. nowe -> w realizacji -> gotowe -> zrealizowane).
*   Możliwość anulowania zamówienia.
*   Usuwanie pozycji z aktywnego zamówienia.
*   Automatyczne zwalnianie stolika po zakończeniu lub anulowaniu zamówienia.
*   Wyświetlanie statystyk (całkowita liczba zamówień, zrealizowane, anulowane, całkowity dochód).
*   Wyświetlanie najpopularniejszych dań.
