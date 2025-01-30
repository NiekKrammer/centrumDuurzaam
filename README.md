# kringloop centrum Duurzaam

Een simpel management systeem voor kringloop centrum Duurzaam

---

## Beschrijving
Dit project is gebouwd met PHP en MySQL en is bedoeld om te draaien in een lokale ontwikkelomgeving. Hierbij kun je het best xampp gebruiken.

---

## Installatie-instructies
Volg deze stappen om het project op je lokale machine in te stellen.

### Vereisten
- **XAMPP** (PHP en MySQL ondersteuning vereist)

### Stappen

1. **Download het ZIP-archief:**
   - Klik op de verstrekte downloadlink of kloon de repository.

2. **Pak het ZIP-bestand uit:**
   - Pak de inhoud uit naar een map naar keuze.

3. **Verplaats de uitgepakte map:**
   - Ga naar je XAMPP-installatiemap (meestal `C:\xampp`).
   - Zoek de map `htdocs` en plaats de uitgepakte map hierin.

4. **Importeer de database:**
   - Open je browser en ga naar `http://localhost/phpmyadmin/`.
   - Maak een nieuwe database aan met een naam naar keuze.
   - Klik op de nieuw aangemaakte database en selecteer het **Importeren**-tabblad.
   - Blader naar de map **`sql`** binnen de uitgepakte projectmap en selecteer het meegeleverde `.sql`-bestand.
   - Klik op **Start** om de database in te laden.

5. **Start de XAMPP-server:**
   - Open het XAMPP-configuratiescherm.
   - Start de modules **Apache** en **MySQL**.

6. **Toegang tot de applicatie:**
   - Open je browser en ga naar `http://localhost/[mapnaam]`, waarbij `[mapnaam]` de naam is van de uitgepakte projectmap.

---

## Probleemoplossing
- **Poortproblemen:** Als Apache of MySQL niet start, controleer dan of poorten `80` en `3306` niet in gebruik zijn door andere applicaties.
- **Database importfouten:** Controleer of het juiste `.sql`-bestand is geüpload en dat er geen syntaxisfouten optreden tijdens de import.

Veel plezier met het project!