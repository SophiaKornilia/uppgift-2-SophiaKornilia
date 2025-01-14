# FSU23D-Systemutveckling-Uppgift-2

Bygg en SaaS-tjänst för att kunder ska kunna hantera sina epost-listor. Vi kommer ha 2 roller av användare, kunder och prenumeranter, där en kund kan se en lista med uppgifter prenumeranter som har valt att prenumerera på deras nyhetsbrev.

FSU23D-Systemutveckling-Uppgift-2 är ett projekt för att bygga en SaaS-tjänst som låter kunder hantera sina e-postlistor. Projektet kräver att utveckla en plattform med två typer av användare: kunder och prenumeranter. Kunder kan se en lista på prenumeranter som har valt att prenumerera på deras nyhetsbrev, medan prenumeranter kan registrera sig för och avregistrera sig från nyhetsbrev. Projektet använder en MySQL-databas (eller MariaDB) och kräver att alla sidor är byggda i PHP, utan användning av React eller API:er. Funktioner som inloggning, lösenordsåterställning och e-postutskick är implementerade.

# Projektstart

Detta är ett PHP-projekt som använder Docker för att köra applikationen i en container.

## Förutsättningar

- Docker måste vara installerat på din dator.
- Om du inte har Docker, vänligen följ [denna länk för att installera Docker](https://www.docker.com/get-started).

## Steg för att starta upp projektet

1. **Öppna terminalen** i din kodredigerare (t.ex. VSCode) eller i din systemterminal.

2. **Navigera till projektets rotmapp** där din `docker-compose.yml`-fil finns, uppgift-2-SophiaKornilia

3. **Bygg och starta containrarna**:
   Kör följande kommando i terminalen:

   docker-compose up

   Detta kommer att bygga och starta containrarna som definieras i `docker-compose.yml`.

4. **Kör Docker i bakgrunden**:
   Starta din docker-container eller om du vill köra Docker-containrarna i bakgrunden och fortsätta arbeta i terminalen kan du använda:

   docker-compose up -d

5. **Kontrollera att containrarna körs**:
   För att se att alla containrar körs korrekt, använd:

   docker ps

6. **Åtkomst till applikationen via webbläsaren**:
   Öppna din webbläsare och gå till:

   http://localhost:PORT

   Ersätt `PORT` med den port som definieras i `docker-compose.yml` (vanligtvis 8080 eller 80).

7. **Stäng av Docker-containrarna**:
   När du är klar med projektet kan du stoppa och ta bort de körande containrarna med:

   docker-compose down

## Felsökning

- Om du stöter på problem med att starta containrarna, kan du kolla loggarna med:

  docker-compose logs

- Om byggprocessen misslyckas kan du prova att bygga containrarna manuellt med:

  docker-compose build

## Mer information

För mer information om Docker och hur man använder det, besök [Docker dokumentation](https://docs.docker.com/).
