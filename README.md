## 1. Databázová konfigurace

Projekt využívá relační databázi mariadb pro ukládání dat.

* **Název databáze:** `recipes`
* **Import výchozích dat:** V kořenovém adresáři projektu se nachází přiložená složka `sql`. Složka obsahuje inicializační databázové příkazy a slouží k automatickému naplnění databáze.

## 2. Docker soubory
V adresáři se vyskytují také složky pro nastavení projektu v Dockeru. Pro spuštění aplikace docker není potřeba. Nastavení neobsahuje nastavení databáze, pouze připojení na externí container s již existující databází. Pro připojení vlastní databáze prosím upravte `/server/db.php`.