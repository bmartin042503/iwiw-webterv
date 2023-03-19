class User {
    constructor(
        nem, 
        nev, 
        szulDatum, 
        email,
        lakhely,
        munkahely,
        tanulmanyok,
        ismerosokSzama, 
        profilkepUrl,
        magassag,
        suly,
        bemutatkozas,
        regisztracioIdeje,
        iwiwplus
        ) {
        this.nem = nem;
        this.nev = nev;
        this.szulDatum = szulDatum;
        this.email = email;
        this.lakhely = lakhely;
        this.munkahely = munkahely;
        this.tanulmanyok = tanulmanyok;
        this.ismerosokSzama = ismerosokSzama;
        this.profilkepUrl = profilkepUrl || "../img/static/default-profile.png";
        this.magassag = magassag;
        this.suly = suly;
        this.bemutatkozas = bemutatkozas;
        this.regisztracioIdeje = regisztracioIdeje;
        this.iwiwplus = iwiwplus || false;
    }
}

const users = [
    new User(
        0, "Nagy Béla", 
        "1964/05/25", 
        "nagy.bela@example.com",
        "Balatonakarattya",
        "nyugdijas",
        "Balatonakarattyai Gimnazium",
        456, 
        "../img/static/users/user-1.png",
        175,
        96,
        "szia nagy béla vagyok, 1964-ben születtem Balatonkarattyán. Kedvenc hobbim az autók, szeretek utazni, olvasni, sportolni. Kerékpározás és futás, ezek azért jok, mert fittek maradunk.",
        "2016. 06. 21.",
        false
        ),
    new User(
        1, "Kovács Anna", 
        "1998/02/14", 
        "kanna98@example.com",
        "Debrecen",
        "Magyar Telekom Nyrt.",
        "Debreceni Egyetem",
        102, 
        "../img/static/default-profile.png",
        164,
        62,
        "-",
        "2009. 11. 30.",
        false
        ),
    new User(
        0, "Szabó Peti", 
        "2001/11/08", 
        "szapeter@example.com", 
        "Kecskemét",
        "-",
        "Szegedi Tudományegyetem",
        34, 
        "../img/static/users/user-2.png",
        187,
        78,
        "Szabó Peti vagyok, 2001-ben születtem. Jelenleg még diák vagyok, de szeretnék a jövőben programozóként dolgozni.",
        "2013. 08. 05.",
        false
        ),
    new User(
        0, "Arató András", 
        "1945/06/11", 
        "arato.andras@example.com",
        "Kőszeg",
        "nyugdíjas vagyok (korábban: Műszaki igazgató, HOLUX Kft. - Világítás és Villamosság)",
        "Budapesti Műszaki Egyetem",
        2152, 
        "../img/static/users/user-4.png",
        178,
        81,
        "Szia, én vagyok Arató András, de az interneten inkább csak 'Hide the Pain Harold'-ként ismernek. Az én arcomat használják különböző vicces képekhez és videókhoz, és így lett belőlem egy magyar mémsztár. Az én életemet az interneten megosztott képek és videók ölelik körbe, de én magam egy egyszerű ember vagyok a vidéken, aki szeret főzni és kirándulni a természetben. Az interneten szerzett hírnév mellett, dolgozom fotósként is, és előfordult már, hogy reklámfilmekben is feltűntem. Nagyon hálás vagyok azért, hogy a humorommal és a mosolygós arcommal ennyi embert tudtam megnevettetni és boldogabbá tenni a világon.",
        "2011. 02. 21.",
        true),
    new User(
        0, "Kovács Gábor", 
        "1995/12/01", 
        "gabor@example.com",
        "Budapest",
        "DanubeTech CEO",
        "ELTE",
        391, 
        "../img/static/users/user-5.png",
        179,
        71,
        "-",
        "2011. 09. 02.",
        false
        ),
    new User(
        0, "Kertész Kolompár", 
        "2002/03/27", 
        "kkolomp@example.com",
        "Szeged",
        "sehol xd",
        "suli",
        132,
        "../img/static/users/user-6.png",
        -1,
        -1,
        "sziasztok xd szeretek fortnitozni",
        "2012. 07. 29.",
        false
        ),
    new User(
        1, "Varga Boglárka", 
        "2000/08/10", 
        "boglarka@example.com",
        "Győr",
        "Tesco",
        "Győri Gimnázium", 
        987,
        "../img/static/default-profile.png",
        175,
        68,
        "Győri vagyok és szeretem a kecskéket",
        "2020. 03. 15.",
        false
        ),
    new User(
        1, "Balázs Judit", 
        "1994/06/17", 
        "bjudit@example.com",
        "London",
        "-",
        "Deák Ferenc Gimnázium", 
        23, 
        "../img/static/default-profile.png",
        164,
        65,
        "Judit Balázs vagyok, 1994-ben születtem és jelenleg Londonban élek. Szeretek túrázni, játszani és rajzolni, életem a zene.",
        "2014. 03. 02.",
        true
        ),
    new User(
        0, "Kovács József", 
        "2000/10/02", 
        "kjozsi2000@example.com",
        "Paks",
        "Sajtos Étterem",
        "Szakácsképző Iskola", 
        347, 
        "../img/static/users/user-9.png",
        -1,
        -1,
        "Imádok sütni, főzni, én magam is egy étteremben dolgozom szakácsként. Írj és ismerj meg jobban!:)",
        "2017. 12. 26.",
        false
        ),
    new User(
        0, "Juhász Erzsébet", 
        "1953/01/09", 
        "juhasz.erzsi@example.com",
        "Heréd",
        "NYUGDIJAS",
        "iskola", 
        156, 
        "../img/static/users/user-10.png",
        -1,
        -1,
        "NYUGDIJAS VAGYOK MINDENKINEK SZEP NAPOT IWIW PUSZI ERZSI",
        "2021. 10. 04.",
        false
        )
];





