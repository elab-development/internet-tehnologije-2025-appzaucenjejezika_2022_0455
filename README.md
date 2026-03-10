# Veb aplikacija za učenje jezika

## Opis aplikacije
Ova aplikacija predstavlja web sistem za učenje stranih jezika, inspirisan platformama za interaktivno učenje kao što je Duolingo, ali u jednostavnijoj formi.  
Korisnicima omogućava da kroz kurseve, lekcije i različite tipove zadataka uče strani jezik, prate svoj napredak i koriste audio sadržaj za vežbanje izgovora i prepoznavanja reči.

Aplikacija podržava:
- registraciju i prijavu korisnika
- pregled dostupnih kurseva i lekcija
- rešavanje zadataka unutar lekcija
- audio zadatke
- prikaz napretka korisnika
- administratorski deo za upravljanje kursevima, lekcijama i zadacima

## Korišćene tehnologije

### Frontend
- React – razvoj korisničkog interfejsa
- Vite – alat za razvoj i build frontend aplikacije
- Tailwind CSS – stilizacija korisničkog interfejsa
- Axios – komunikacija sa backend API-jem
- Recharts – vizualizacija napretka korisnika

### Backend
- Laravel – razvoj REST API backend sistema
- Laravel Sanctum – autentifikacija i zaštita ruta
- Eloquent ORM – rad sa bazom podataka

### Baza podataka
- MySQL – čuvanje korisnika, kurseva, lekcija, zadataka i napretka

### DevOps i alati
- Docker – kontejnerizacija aplikacije
- Docker Compose – orkestracija servisa
- GitHub – verzionisanje i timska saradnja
- GitHub Actions – CI/CD pipeline
- Railway – cloud deployment

## Struktura projekta
Projekat je podeljen na dva glavna dela:
- frontend/ – React aplikacija
- backend/ – Laravel API

## Pokretanje aplikacije lokalno

### 1. Kloniranje repozitorijuma
```bash
git clone <LINK_DO_REPOZITORIJUMA>
cd <IME_PROJEKTA>
```
### 2. Pokretanje backend dela
Preći u backend direktorijum:
```bash
cd backend
```

Instalirati zavisnosti:
```bash
composer install
```

Kopirati `.env` fajl:
```bash
cp .env.example .env
```

Generisati aplikacijski ključ:
```bash
php artisan key:generate
```

Podesiti konekciju ka MySQL bazi u `.env` fajlu.

Pokrenuti migracije i seedere:
```bash
php artisan migrate --seed
```

Pokrenuti Laravel server:
```bash
php artisan serve
```

Backend će biti dostupan na:
```
http://127.0.0.1:8000
```
### 3. Pokretanje frontend dela
Otvoriti novi terminal i preći u frontend direktorijum:
```bash
cd frontend
```

Instalirati zavisnosti:
```bash
npm install
```

Pokrenuti development server:
```bash
npm run dev
```

Frontend će biti dostupan na:
```
http://localhost:5173
```

## Pokretanje aplikacije pomoću Docker-a i Docker Compose-a

Aplikacija je dockerizovana i sastoji se iz tri servisa:
- mysql
- backend
- frontend
### Pokretanje prvi put
```bash
docker-compose up --build
```
### Svako naredno pokretanje
```bash
docker-compose up
```
### Pokretanje u pozadini
```bash
docker-compose up -d
```
### Zaustavljanje servisa
```bash
docker-compose down
```
### Zaustavljanje i brisanje volumena
```bash
docker-compose down -v
```

## Način rada sistema
Frontend komunicira sa backend-om putem REST API-ja koristeći HTTP/HTTPS protokol, dok backend koristi MySQL bazu podataka za čuvanje svih informacija o korisnicima, kursevima, lekcijama, zadacima i napretku.

## Autori
- Teodora Đorđević – 2022/0436
- Ana Đurić – 2022/0455
- Milica Janković – 2022/0301

## Mentor
- Aleksandar Joksimović
