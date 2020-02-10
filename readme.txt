Testovací plugin

Projekt na stiahnutie => https://github.com/MatusVrsansky/Test-Plugin-Wordpress

Rozbehať si projekt treba nasledovane:
- naclonovat projekt odtialto => https://github.com/MatusVrsansky/Test-Plugin-Wordpress
- zobrat DB z priecinka => ishyoboy/sql
- importnut do novej db s nazvom => ishyoboy
- lokalne url
    - homepage -> http://ishyoboy-assigment.test/
    - wp-admin -> http://ishyoboy-assigment.test/wp-admin
- ja ako web server u mna na pc pouzivam WAMP
- prihlasovacie udaje do wp-admin poslem cez mail

POSTUP

- nakonfigurovanie webpacku pre moj SASS subor a JS subor (praca so sliderom)
- zbehol som v root projektu
  - npm init -y (package.json je v give projektu, tak ten uz tam mate)

  - ak by ste chceli robit zmeny v sass a js pre moj custom slider, tak:
  - npm install --save-dev webpack  webpack-cli - tym sa vytvori node_modules a package-lock.json
  - npm install --save-dev style-loader css-loader

  Spustenie webpacku po zmenach:
  - npm start

OSTATOK ako som presne postupoval pri vypracovani zadania, co sa mi podarilo, pripadne nepodarilo spravit by som rad povedal cez call
a nazorne ukazal, kde co presne je :)



