class User {
    constructor(nem, nev, szulDatum, email, ismerosokSzama, profilkepUrl) {
        this.nem = nem;
        this.nev = nev;
        this.szulDatum = szulDatum;
        this.email = email;
        this.ismerosokSzama = ismerosokSzama;
        this.profilkepUrl = profilkepUrl || "../img/static/default-profile.png";
    }
}

const users = [
    new User(0, "Nagy Béla", "1999/05/25", "bela@example.com", 456, "../img/users/user-1.png"),
    new User(1, "Kovács Anna", "1998/02/14", "anna@example.com", 102, "../img/static/default-profile.png"),
    new User(0, "Szabó Peti", "2001/11/08", "peter@example.com", 34, "../img/users/user-2.png"),
    new User(0, "Arató András", "1945/05/11", "arato.andras@example.com", 789, "../img/users/user-4.png"),
    new User(0, "Kovács Gábor", "1995/12/01", "gabor@example.com", 65, "../img/users/user-5.png"),
    new User(0, "Kertész Kolompár", "2002/03/27", "andras@example.com", 432, "../img/users/user-6.png"),
    new User(1, "Varga Boglárka", "2000/08/10", "boglarka@example.com", 987, "../img/static/default-profile.png"),
    new User(1, "Balázs Judit", "1994/06/17", "judit@example.com", 23, "../img/static/default-profile.png"),
    new User(0, "Molnár Zsolt", "1997/01/09", "zsolt@example.com", 156, "../img/users/user-9.png"),
    new User(0, "Kovács József", "2000/10/02", "istvan@example.com", 347, "../img/users/user-10.png")
];





