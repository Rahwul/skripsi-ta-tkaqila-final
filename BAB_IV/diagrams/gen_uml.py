import urllib.request
import os
import zlib
import base64
import string

diagrams = {
    "faris_usecase.png": """@startuml
left to right direction
actor "Orang Tua / Wali Murid" as ortu
actor "Admin TK Aqila" as admin

rectangle "Sistem Front End Pendaftaran (Laravel)" {
  usecase "Registrasi Akun" as UC1
  usecase "Login ke Sistem" as UC2
  usecase "Mengisi Form Pendaftaran" as UC3
  usecase "Melihat Status Pendaftaran" as UC4
  usecase "Melihat Daftar Peserta" as UC5
  usecase "Memverifikasi (Setuju/Tolak)" as UC6
  usecase "Melihat Laporan" as UC7
}

ortu --> UC1
ortu --> UC2
ortu --> UC3
ortu --> UC4

admin --> UC2
admin --> UC5
admin --> UC6
admin --> UC7
@enduml""",

    "rahwul_usecase.png": """@startuml
left to right direction
actor "Client App (Front End)" as client

rectangle "Sistem Back End API (Golang & MySQL)" {
  usecase "POST /auth/register\\n(Registrasi)" as API1
  usecase "POST /auth/login\\n(Generate JWT)" as API2
  usecase "GET /me\\n(Ambil Profil)" as API3
  usecase "POST /students\\n(Simpan Data Anak)" as API4
  usecase "GET /students\\n(List Pendaftar)" as API5
  usecase "PUT /students/status\\n(Update Status)" as API6
}

client --> API1
client --> API2
client --> API3
client --> API4
client --> API5
client --> API6
@enduml""",

    "faris_activity.png": """@startuml
|Orang Tua|
start
:Buka menu Pendaftaran;
:Input Data Anak & Orang Tua;
:Klik "Submit";
|Sistem|
while (Apakah ada data kosong?) is (Ya)
  :Tampilkan pesan error warna merah;
  |Orang Tua|
  :Perbaiki Input;
  :Klik "Submit";
  |Sistem|
endwhile (Tidak)
:Validasi ke server;
:Proses Pendaftaran Berhasil;
:Tampilkan Halaman Sukses;
stop
@enduml""",

    "rahwul_activity.png": """@startuml
start
:Terima HTTP POST /api/auth/login;
:Parsing payload JSON (email & password);
:Query Database (GORM) berdasarkan email;
if (Email ditemukan?) then (Tidak)
  :Kirim JSON Error (401 Unauthorized);
  stop
else (Ya)
  if (Password Hash Cocok?) then (Tidak)
    :Kirim JSON Error (401 Unauthorized);
    stop
  else (Ya)
    :Generate JWT Token;
    :Kirim JSON Response + Token (200 OK);
    stop
  endif
endif
@enduml""",

    "faris_sequence.png": """@startuml
actor "Orang Tua" as ortu
boundary "Pendaftaran View\\n(Blade)" as view
control "Pendaftaran Controller" as ctrl

ortu -> view : Mengisi form & Klik Submit
activate view
view -> ctrl : HTTP POST /daftar
activate ctrl
ctrl -> ctrl : Validasi Laravel Request

alt Data Tidak Valid
    ctrl --> view : Redirect Back with Errors
    view --> ortu : Tampilkan peringatan merah
else Data Valid
    ctrl -> ctrl : Simpan / Teruskan ke API
    ctrl --> view : Redirect to Sukses
    view --> ortu : Tampilkan Halaman Sukses
end
deactivate ctrl
deactivate view
@enduml""",

    "rahwul_sequence.png": """@startuml
participant "Client Application" as client
participant "GoFiber Router" as router
participant "JWT Middleware" as mw
participant "Student Handler" as handler
database "MySQL Database\\n(via GORM)" as db

client -> router : HTTP POST /api/students (Bearer)
activate router
router -> mw : Cek Validitas Token
activate mw
alt Token Tidak Valid/Kosong
    mw --> client : HTTP 401 Unauthorized
else Token Valid
    mw -> handler : Teruskan Request (Lolos)
end
deactivate mw

activate handler
handler -> handler : Parsing JSON & Validasi Payload
handler -> db : Create(&student)
activate db
db --> handler : Data Tersimpan / Error
deactivate db

handler --> client : HTTP 201 Created (JSON Response)
deactivate handler
deactivate router
@enduml""",

    "system_class.png": """@startuml
skinparam classAttributeIconSize 0

class User {
  +ID : uint
  +Name : string
  +Email : string
  +PasswordHash : string
  +Role : ENUM('admin', 'operator', 'wali murid')
}

class Student {
  +ID : uint
  +FullName : string
  +BirthDate : date
  +Gender : ENUM('L', 'P')
  +Address : text
  +ParentName : string
  +ParentPhone : string
}

class Class {
  +ID : uint
  +Name : string
  +Level : string
  +Quota : int
  +ScheduleDay : string
  +ScheduleStart : string
  +ScheduleEnd : string
}

class Registration {
  +ID : uint
  +StudentID : uint
  +ClassID : uint
  +RegistrationCode : string
  +RegistrationDate : datetime
  +Status : ENUM('pending', 'accepted', 'rejected')
}

Student "1" - "*" Registration : memiliki >
Class "1" - "*" Registration : mencakup >
@enduml""",

    "faris_architecture.png": """@startuml
node "Orang Tua / Admin" as user
node "Browser / Device" as browser {
  component "View Layer\\n(Blade & TailwindCSS)" as view
}
node "Web Server (Laravel)" as server {
  component "Web Routes" as route
  component "Controllers" as ctrl
}
cloud "REST API Backend" as backend

user <--> view : Interaksi UI
view <--> route : User Input
route <--> ctrl : Routing
ctrl <--> backend : Meneruskan Request API
@enduml""",

    "rahwul_architecture.png": """@startuml
node "Client Apps / Front End" as client
node "Backend Server (Golang)" as server {
  component "GoFiber Router" as route
  component "Auth Middleware\\n(JWT)" as mw
  component "Controllers / Handlers" as ctrl
  component "GORM Repositories" as repo
}
database "MySQL Database" as db

client <--> route : HTTP Request
route <--> mw
mw <--> ctrl : Token Valid
ctrl <--> repo
repo <--> db : Query / Simpan Data
@enduml"""
}

def encode_plantuml(text):
    zlibbed_str = zlib.compress(text.encode('utf-8'))
    compressed_string = zlibbed_str[2:-4]
    b64_str = base64.b64encode(compressed_string).decode('utf-8')
    b64_alphabet = string.ascii_uppercase + string.ascii_lowercase + "0123456789+/"
    puml_alphabet = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-_"
    trans = str.maketrans(b64_alphabet, puml_alphabet)
    return b64_str.translate(trans)

out_dir = r"c:\laragon\www\web-pendaftaran-tkaqila\BAB_IV\diagrams"
url_template = "http://www.plantuml.com/plantuml/png/{}"

for filename, puml in diagrams.items():
    print(f"Generating {filename}...")
    encoded = encode_plantuml(puml)
    url = url_template.format(encoded)
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
    try:
        with urllib.request.urlopen(req) as response:
            with open(os.path.join(out_dir, filename), 'wb') as f:
                f.write(response.read())
    except Exception as e:
        print(f"Failed: {e}")

print("Done!")
