<?php
   /**
    * JMBG.php
    *
    * Provera JMBG-a i i uzimanje podataka o rodjenju / prebivalistu
    *
    * @category   Alat
    * @author     Srdjan Pavlica
    * @copyright  2018 Srdjan Pavlica
    */
   class JMBG
   {
      private $num = 0;

      public function __construct( $n = false )
      {
         if ( $n == false )
         {
            throw new \Exception("<br><strong>Nije upisan broj za proveru!</strong><br>", 1);
         }

         $this->num = $n;
      }

      /**
       *
       * Proverava JMBG i vraca true ako je sve u redu ili false ako nesto nije u redu
       *
       * @return      bool
       *
       */
      public function isOK()
      {
         // odbaci brojeve neispravne duzine
         if ( strlen($this->num) != 13 )
            return false;

         // odbaci nule
         if ( $this->num == "0000000000000" )
            return false;

         $n = $this->num; // daj ga u varijablu, preglednije je za sabiranje

         // napravi sumu
         $s = 7*$n[0] + 6*$n[1] + 5*$n[2] + 4*$n[3] + 3*$n[4] + 2*$n[5] +
              7*$n[6] + 6*$n[7] + 5*$n[8] + 4*$n[9] + 3*$n[10] + 2*$n[11];

         // kontrolna cifra suma mod 11
         $k = $s % 11;

         // ako si veci od 1, oduzmi od 11
         if ( $k > 1 )
            $k = 11 - $k;

         // da li je kontrolna cifra ista kao i ona na 13 mestu?
         if ( $k == $n[12] )
            return true;
         else
            return false;
      }

      /**
       *
       * Uzima podatke koji se mogu uzeti iz broja.
       *
       * @return      array
       *              ["bday"]    -> datum rodjenja u ISO 8601 formatu ( YYYY-MM-DD )
       *              ["gender"]  -> pol
       *              ["region"]  -> glavni region rodjenja
       *              ["region2"] -> pod region rodjenja
       *
       */
      public function getPersonData ()
      {
         //proveri sam sebe
         if ( !$this->isOK() )
         {
            echo "Broj nije ispravan, nema podataka! Prvo uradi proveru broja, pa tek onda prikazi podatke.";
         }

         $data = array ();

         // provera pola
         $g = substr ( $this->num, 9,3 );
         if ( $g >= 0 && $g <= 499)
            $data["gender"] = "M";
         else
            $data["gender"] = "Ž";

         // provera regiona rodjenja
         $region = substr ( $this->num, 7, 2 );
         if ( $region >= 0 && $region <= 9 )   // Stranci
         {
            $data["region"] = "Stranci koji su dobili SFRJ drzavljanstvo";
            switch ($region)
            {
               case 1: $data["region2"] = "Stranci u BiH"; break;
               case 2: $data["region2"] = "Stranci u Crnoj Gori"; break;
               case 3: $data["region2"] = "Stranci u Hrvatskoj"; break;
               case 4: $data["region2"] = "Stranci u Makedoniji"; break;
               case 5: $data["region2"] = "Stranci u sloveniji"; break;
               case 7: $data["region2"] = "Stranci u Užoj Srbiji"; break;
               case 8: $data["region2"] = "Stranci u Vojvodini"; break;
               case 9: $data["region2"] = "Stranci na Kosovu i Metohiji"; break;
            }
         }
         if ( $region >= 10 && $region <= 19 ) // BiH
         {
            $data["region"] = "Bosna i Hercegovina";
            switch ($region)
            {
               case 10: $data["region2"] = "Banja Luka"; break;
               case 11: $data["region2"] = "Bihać"; break;
               case 12: $data["region2"] = "Doboj"; break;
               case 13: $data["region2"] = "Goražde"; break;
               case 14: $data["region2"] = "Livno"; break;
               case 15: $data["region2"] = "Mostar"; break;
               case 16: $data["region2"] = "Prijedor"; break;
               case 17: $data["region2"] = "Sarajevo"; break;
               case 18: $data["region2"] = "Tuzla"; break;
               case 19: $data["region2"] = "Zenica"; break;
            }
         }
         if ( $region >= 20 && $region <= 29 ) // Crna Gora
         {
            $data["region"] = "Crna gora";
            switch ($region)
            {
               case 21: $data["region2"] = "Podgorica"; break;
               case 22: $data["region2"] = "Bar, Ulcinj"; break;
               case 23: $data["region2"] = "Budva, Kotor, Tivat"; break;
               case 24: $data["region2"] = "Herceg Novi"; break;
               case 25: $data["region2"] = "Cetinje"; break;
               case 26: $data["region2"] = "Nikšić"; break;
               case 27: $data["region2"] = "Berane, Rožaje, Plav, Andrijevica"; break;
               case 28: $data["region2"] = "Bijelo Polje, Mojkovac"; break;
               case 29: $data["region2"] = "Žabljak"; break;
            }
         }
         if ( $region >= 30 && $region <= 39 ) // Hrvatska
         {
            $data["region"] = "Hrvatska";
            switch ($region)
            {
               case 30: $data["region2"] = "Osijek"; break;
               case 31: $data["region2"] = "Bjelovar, Virovitica, Koprivnica, Pakrac"; break;
               case 32: $data["region2"] = "Varaždin, Međumirje"; break;
               case 33: $data["region2"] = "Zagreb"; break;
               case 34: $data["region2"] = "Karlovac"; break;
               case 35: $data["region2"] = "Lika"; break;
               case 36: $data["region2"] = "Istra, Primorje"; break;
               case 37: $data["region2"] = "Sisak, Banija"; break;
               case 38: $data["region2"] = "Dalmacija"; break;
               case 39: $data["region2"] = "Razno"; break;
            }
         }
         if ( $region >= 40 && $region <= 49 ) // Makedonija
         {
            $data["region"] = "Makedonija";
            switch ($region)
            {
               case 41: $data["region2"] = "Bitolj"; break;
               case 42: $data["region2"] = "Kumanovo"; break;
               case 43: $data["region2"] = "Ohrid"; break;
               case 44: $data["region2"] = "Prilep"; break;
               case 45: $data["region2"] = "Skoplje"; break;
               case 46: $data["region2"] = "Strumica"; break;
               case 47: $data["region2"] = "Tetovo"; break;
               case 48: $data["region2"] = "Veles"; break;
               case 49: $data["region2"] = "Štip"; break;
            }
         }
         if ( $region >= 50 && $region <= 59 ) // Slovenija
         {
            $data["region"] = "Slovenija";
            // nema pod regiona
         }
         if ( $region >= 60 && $region <= 69 ) // Privremeni boravak
         {

            $data["region"] = "Gradjani sa privremenim boravkom";
         }
         if ( $region >= 70 && $region <= 79 ) // Srbija
         {
            $data["region"] = "Uža Srbija";
            switch ($region)
            {
               case 71: $data["region2"] = "Beograd"; break;
               case 72: $data["region2"] = "Kragujevac, Jagodina"; break;
               case 73: $data["region2"] = "Niš, Pirot, Toplica"; break;
               case 74: $data["region2"] = "Leskovac, Vranje"; break;
               case 75: $data["region2"] = "Zaječar, Bor"; break;
               case 76: $data["region2"] = "Smederevo, Požarevac"; break;
               case 77: $data["region2"] = "Mačva, Kolubara"; break;
               case 78: $data["region2"] = "Čačak, Kraljevo, Kruševac"; break;
               case 79: $data["region2"] = "Užice"; break;
            }
         }
         if ( $region >= 80 && $region <= 89 ) // Vojvodina
         {
            $data["region"] = "AP Vojvodina";
            switch ($region)
            {
               case 80: $data["region2"] = "Novi Sad"; break;
               case 81: $data["region2"] = "Sombor"; break;
               case 82: $data["region2"] = "Subotica"; break;
               case 83: $data["region2"] = "Vrbas"; break;
               case 84: $data["region2"] = "Kikinda"; break;
               case 85: $data["region2"] = "Zrenjanin"; break;
               case 86: $data["region2"] = "Pančevo"; break;
               case 87: $data["region2"] = "Vršac"; break;
               case 88: $data["region2"] = "Ruma"; break;
               case 89: $data["region2"] = "Sremska Mitrovica"; break;
            }
         }
         if ( $region >= 90 && $region <= 99 ) // Kosovo
         {
            $data["region"] = "AP Kosovo";
            switch ($region)
            {
               case 91: $data["region2"] = "Priština"; break;
               case 92: $data["region2"] = "Kosovska Mitrovica"; break;
               case 93: $data["region2"] = "Peć"; break;
               case 94: $data["region2"] = "Djakovica"; break;
               case 95: $data["region2"] = "Prizren"; break;
               case 96: $data["region2"] = "Gnjilane, Kosovska Kamenica, Vitina, Novo Brdo"; break;
            }
         }

         if ( $this->num[5] == 0 )
            $vek = 2;
         else
            $vek = 1;

         $tempGod = $vek . substr($this->num, 4, 3);
         $data["bday"] = $tempGod . "-" . substr($this->num, 2, 2) . "-" . substr($this->num, 0, 2);

         return $data;
      }
   }
?>
