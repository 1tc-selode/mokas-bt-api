# Laravel Task API - Dolgozat Kérdések és Válaszok

## 1. Laravel Framework Alapok

### Kérdés 1.1: Mi a Laravel, és milyen fő előnyei vannak?
**Válasz:** A Laravel egy PHP webalkalmazás keretrendszer, amely expressz és elegáns szintaxissal rendelkezik. Fő előnyei:
- Egyszerű, gyors routing motor
- Hatékony dependency injection konténer
- Több backend támogatás session és cache tároláshoz
- Kifejező, intuitív adatbázis ORM (Eloquent)
- Adatbázis-független schema migrációk
- Robusztus háttérfolyamat kezelés
- Valós idejű esemény sugárzás

### Kérdés 1.2: Milyen verziókat használ ez a projekt?
**Válasz:**
- PHP: ^8.2
- Laravel Framework: ^12.0
- Laravel Sanctum: ^4.0

---

## 2. MVC Architektúra

### Kérdés 2.1: Mi az MVC minta, és hogyan jelenik meg a Laravel-ben?
**Válasz:** Az MVC (Model-View-Controller) egy szoftver tervezési minta:
- **Model (Modell)**: Adatstruktúra és üzleti logika - `app/Models/Task.php`
- **View (Nézet)**: Felhasználói felület - `resources/views/`
- **Controller (Vezérlő)**: Közbülső logika - `app/Http/Controllers/TaskController.php`

### Kérdés 2.2: Milyen felelősségei vannak a TaskController-nek?
**Válasz:** A TaskController felelős a task-okkal kapcsolatos HTTP kérések kezeléséért:
- `index()`: Összes task listázása
- `store()`: Új task létrehozása
- `show($id)`: Egy konkrét task megjelenítése
- `update($id)`: Task módosítása
- `destroy($id)`: Task törlése

---

## 3. RESTful API Végpontok

### Kérdés 3.1: Sorolja fel az összes API végpontot és azok HTTP metódusát!
**Válasz:**
```php
GET    /api/tasks        // Összes task lekérése
GET    /api/tasks/{id}   // Egy task lekérése
POST   /api/tasks        // Új task létrehozása
PUT    /api/tasks/{id}   // Task frissítése
DELETE /api/tasks/{id}   // Task törlése
```

### Kérdés 3.2: Mi a különbség a GET és POST metódus között?
**Válasz:**
- **GET**: Adatok lekérésére szolgál, idempotens (többszöri végrehajtás ugyanazt az eredményt adja), adatok az URL-ben vannak
- **POST**: Új erőforrás létrehozására szolgál, nem idempotens, adatok a request body-ban vannak

### Kérdés 3.3: Milyen HTTP státuszkódokat használ az API?
**Válasz:**
- **200 OK**: Sikeres GET, PUT, DELETE műveletek
- **201 Created**: Sikeres POST művelet (új resource létrehozva)

---

## 4. Eloquent ORM és Modellek

### Kérdés 4.1: Mi a Task modell szerepe?
**Válasz:** A Task modell reprezentálja a tasks adatbázis táblát és definiálja az adatstruktúrát:
```php
class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'status'];
}
```

### Kérdés 4.2: Mit jelent a $fillable tulajdonság?
**Válasz:** A `$fillable` tömb meghatározza, hogy mely mezők tölthetők fel tömeges hozzárendeléssel (mass assignment). Ez egy biztonsági mechanizmus, amely véd a nem kívánt mező módosításoktól.

### Kérdés 4.3: Mi a HasFactory trait célja?
**Válasz:** A `HasFactory` trait lehetővé teszi a model factory-k használatát, amelyekkel könnyedén lehet tesztadatokat generálni a modellhez.

---

## 5. Adatbázis Migrációk

### Kérdés 5.1: Milyen mezőket tartalmaz a tasks tábla?
**Válasz:**
```php
- id: Primary key (auto-increment)
- title: String, max 255 karakter (kötelező)
- description: Text, lehet null
- status: Enum ['függőben', 'folyamatban', 'befejezve'], alapértelmezett: 'függőben'
- timestamps: created_at, updated_at
```

### Kérdés 5.2: Mi a migráció up() és down() metódusának szerepe?
**Válasz:**
- **up()**: A migráció futtatásakor hajtódik végre, létrehozza a táblát vagy módosítja a sémát
- **down()**: A migráció visszavonásakor fut le, visszaállítja a változtatásokat (pl. törli a táblát)

### Kérdés 5.3: Mit jelent az enum típus a status mezőnél?
**Válasz:** Az `enum` típus korlátozza a lehetséges értékeket egy előre meghatározott listára. A status csak három értéket vehet fel: 'függőben', 'folyamatban', vagy 'befejezve'.

---

## 6. Validáció

### Kérdés 6.1: Milyen validációs szabályok vannak a Task létrehozásakor?
**Válasz:**
```php
'title' => 'required|max:255',        // Kötelező, max 255 karakter
'description' => 'nullable',          // Opcionális
'status' => 'required|in:függőben,folyamatban,befejezve'  // Kötelező, csak ezek az értékek
```

### Kérdés 6.2: Mi történik, ha a validáció sikertelen?
**Válasz:** Ha a validáció sikertelen, Laravel automatikusan visszaküld egy 422 Unprocessable Entity státuszkódot és egy JSON választ a hibaüzenetekkel.

### Kérdés 6.3: Miért fontos a validáció?
**Válasz:** A validáció biztosítja:
- Adatintegritást (csak helyes formátumú adatok kerülnek az adatbázisba)
- Biztonságot (véd a rosszindulatú bevitelektől)
- Felhasználói élményt (egyértelmű hibaüzenetek)

---

## 7. Factory és Seeding

### Kérdés 7.1: Mi a TaskFactory feladata?
**Válasz:** A TaskFactory felelős tesztadatok generálásáért a Task modellhez:
```php
'title' => fake()->sentence(2),        // 2 szavas mondat
'description' => fake()->paragraph(),   // Bekezdés
'status' => fake()->randomElement(['függőben','folyamatban','befejezve'])
```

### Kérdés 7.2: Hogyan működik a TaskSeeder?
**Válasz:** A TaskSeeder feltölti az adatbázist kezdeti adatokkal:
1. Factory segítségével létrehoz 3 random taskot
2. Manuálisan létrehoz 2 konkrét taskot tömb alapján
3. Minden taskot ment az adatbázisba

### Kérdés 7.3: Mire használjuk a fake() függvényt?
**Válasz:** A `fake()` (Faker library) random, de valósághű tesztadatok generálására szolgál (nevek, címek, szövegek, stb.).

---

## 8. HTTP Válaszok és JSON

### Kérdés 8.1: Hogyan küld JSON választ a TaskController?
**Válasz:** A `response()->json()` metódussal:
```php
return response()->json($data, $statusCode);
```

### Kérdés 8.2: Mi történik a Task::all() hívásnál?
**Válasz:** Az Eloquent lekérdezi az összes task-ot az adatbázisból egy Collection-ként, amelyet automatikusan JSON formátumba konvertál a response.

### Kérdés 8.3: Mit csinál a findOrFail() metódus?
**Válasz:** Megkeresi a megadott ID-jú rekordot az adatbázisban. Ha megtalálja, visszaadja; ha nem, automatikusan 404 Not Found hibát dob.

---

## 9. CRUD Műveletek

### Kérdés 9.1: Sorolja fel a CRUD műveleteket és a megfelelő controller metódusokat!
**Válasz:**
- **Create (Létrehozás)**: `store()` - új task létrehozása
- **Read (Olvasás)**: `index()` - összes task, `show()` - egy task
- **Update (Frissítés)**: `update()` - task módosítása
- **Delete (Törlés)**: `destroy()` - task törlése

### Kérdés 9.2: Hogyan működik a Task::create() metódus?
**Válasz:** A `create()` metódus:
1. Tömböt vagy kérés adatokat fogad
2. Létrehoz egy új model instance-t
3. Kitölti a $fillable mezőket
4. Elmenti az adatbázisba
5. Visszaadja a létrehozott model-t

### Kérdés 9.3: Mi a különbség a destroy() és delete() között?
**Válasz:**
- **destroy($id)**: Statikus metódus, közvetlenül az ID alapján töröl
- **delete()**: Instance metódus, egy betöltött model-en hívható

---

## 10. Routing

### Kérdés 10.1: Hol vannak definiálva az API route-ok?
**Válasz:** Az `routes/api.php` fájlban. Ezek automatikusan az `/api` prefix-szel érhetők el.

### Kérdés 10.2: Hogyan van összekapcsolva a route és a controller?
**Válasz:**
```php
Route::get('/tasks', [TaskController::class, 'index']);
// HTTP metódus + útvonal => [Controller::class, 'metódus']
```

### Kérdés 10.3: Hogyan adunk át paramétereket a route-ban?
**Válasz:** Kapcsos zárójelekkel: `{id}`, majd a controller metódus paraméterként fogadja:
```php
Route::get('/tasks/{id}', [TaskController::class, 'show']);
public function show($id) { ... }
```

---

## 11. Hibakezelés

### Kérdés 11.1: Mi történik, ha nem létező ID-t kérünk le?
**Válasz:** A `findOrFail()` metódus `ModelNotFoundException`-t dob, amelyet Laravel automatikusan 404 Not Found HTTP válaszra konvertál.

### Kérdés 11.2: Milyen hibák léphetnek fel a store() metódusban?
**Válasz:**
- Validációs hibák (422 Unprocessable Entity)
- Adatbázis kapcsolati hibák (500 Internal Server Error)
- Adatbázis constraint megsértések (pl. túl hosszú title)

---

## 12. Laravel Parancsok

### Kérdés 12.1: Milyen artisan parancsokat használhatunk ehhez a projekthez?
**Válasz:**
```bash
php artisan migrate           # Migrációk futtatása
php artisan db:seed           # Seeder-ek futtatása
php artisan make:controller   # Controller létrehozása
php artisan make:model        # Model létrehozása
php artisan make:migration    # Migráció létrehozása
php artisan serve             # Fejlesztői szerver indítása
```

### Kérdés 12.2: Hogyan futtathatjuk az adatbázis migrációkat és seeder-eket?
**Válasz:**
```bash
php artisan migrate:fresh --seed
# Törli az összes táblát, újra futtatja a migrációkat és a seeder-eket
```

---

## 13. Projekt Struktúra

### Kérdés 13.1: Milyen főbb könyvtárak vannak a Laravel projektben?
**Válasz:**
- **app/**: Az alkalmazás fő logikája (Models, Controllers, stb.)
- **routes/**: Route definíciók
- **database/**: Migrációk, seeders, factories
- **config/**: Konfigurációs fájlok
- **resources/**: Views, CSS, JavaScript
- **public/**: Publikusan elérhető fájlok (index.php, képek)
- **storage/**: Fájltárolás, logok, cache
- **tests/**: Unit és feature tesztek

### Kérdés 13.2: Mi a composer.json szerepe?
**Válasz:** A `composer.json` definiálja:
- A projekt függőségeit (require, require-dev)
- Autoloading beállításokat
- Script-eket (setup, dev, test)
- Projekt metaadatokat

---

## 14. BUG a Kódban!

### Kérdés 14.1: Van-e hiba a Task modellben? Ha igen, mi az?
**Válasz:** **IGEN!** A `$fillable` tömbben elgépelés van:
```php
protected $fillable = [
    'title',
    'description',
    'satus'  // HIBÁS! Helyesen: 'status'
];
```
Ez azt eredményezi, hogy a status mező nem tölthető fel, ezért mindig az alapértelmezett 'függőben' értéket kapja.

---

## 15. API Tesztelés

### Kérdés 15.1: Hogyan tesztelhetjük az API-t Postman-nel vagy cURL-lel?
**Válasz:**
```bash
# Összes task lekérése
GET http://localhost:8000/api/tasks

# Egy task lekérése
GET http://localhost:8000/api/tasks/1

# Új task létrehozása
POST http://localhost:8000/api/tasks
Body: {
  "title": "Új feladat",
  "description": "Leírás",
  "status": "függőben"
}

# Task frissítése
PUT http://localhost:8000/api/tasks/1
Body: {
  "title": "Frissített cím",
  "description": "Új leírás",
  "status": "folyamatban"
}

# Task törlése
DELETE http://localhost:8000/api/tasks/1
```

---

## 16. Összefoglaló Kérdések

### Kérdés 16.1: Írja le az adatfolyamot egy POST /api/tasks kérés esetén!
**Válasz:**
1. HTTP POST kérés érkezik az `/api/tasks` végpontra
2. A Laravel router a `routes/api.php` alapján a `TaskController@store` metódushoz irányít
3. A `store()` metódus validálja a bejövő adatokat
4. Ha sikeres, létrehoz egy új Task instance-t a `Task::create()` hívással
5. Az Eloquent ORM INSERT SQL parancsot hajt végre a tasks táblán
6. A létrehozott task visszaadásra kerül JSON formátumban 201 státuszkóddal

### Kérdés 16.2: Milyen biztonsági intézkedések vannak a kódban?
**Válasz:**
- **Mass Assignment Protection**: `$fillable` tömb véd a nem kívánt mező módosításoktól
- **Input Validáció**: Minden bejövő adat validálásra kerül
- **SQL Injection védelem**: Eloquent ORM prepared statement-eket használ
- **Típus kényszerítés**: enum típus a status mezőnél

### Kérdés 16.3: Hogyan lehetne bővíteni az API-t?
**Válasz:** Lehetséges bővítések:
- Autentikáció (Laravel Sanctum tokenekkel)
- Jogosultságkezelés (csak saját task-ok szerkesztése)
- Lapozás (pagination) nagy adatmennyiség esetén
- Szűrés és keresés funkciók
- Kapcsolatok más modellekkel (pl. User-Task kapcsolat)
- API verziókezelés
- Rate limiting (kérések számának korlátozása)

---

## Gyakorlati Feladatok

### Feladat 1: Írjon egy új API végpontot, amely csak a "befejezve" státuszú task-okat listázza ki!

**Megoldás:**
```php
// routes/api.php
Route::get('/tasks/completed', [TaskController::class, 'completed']);

// TaskController.php
public function completed()
{
    $tasks = Task::where('status', 'befejezve')->get();
    return response()->json($tasks, 200);
}
```

### Feladat 2: Javítsa ki a Task modellben található hibát!

**Megoldás:**
```php
protected $fillable = [
    'title',
    'description',
    'status'  // Javítva: satus -> status
];
```

### Feladat 3: Írjon egy metódust, amely megszámolja az egyes státuszok előfordulását!

**Megoldás:**
```php
// TaskController.php
public function statistics()
{
    $stats = [
        'függőben' => Task::where('status', 'függőben')->count(),
        'folyamatban' => Task::where('status', 'folyamatban')->count(),
        'befejezve' => Task::where('status', 'befejezve')->count(),
        'összesen' => Task::count()
    ];
    return response()->json($stats, 200);
}
```

---

**Sikeres tanulást és dolgozatírást! 📚✨**
