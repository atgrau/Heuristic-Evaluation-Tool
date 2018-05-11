<?php
  /**
   * Countries
   */
  class Country
  {
    private $Iso;
    private $Name;

    function __construct($iso, $name) {
      $this->Iso = $iso;
      $this->Name = $name;
    }

    function GetIso() {
      return $this->Iso;
    }

    function GetName() {
      return $this->Name;
    }
  }

  function GetCountryByIso($iso) {
    $country = DB::queryFirstRow("SELECT iso, name FROM countries WHERE iso=%s", $iso);
    if ($account) {
      return new Country($country["iso"], $country["name"]);
    } else {
      return null;
    }
  }

  function CountryExists($iso) {
    DB::query("SELECT iso, name FROM countries WHERE iso=%s", $iso);
    return DB::count() > 0;
  }

  function GetCountries() {
    $countries = array();
    $country = DB::query("SELECT iso, name FROM countries");
    if ($country) {
      foreach ($country as $row) {
          array_push($countries, new Country($row["iso"], $row["name"]));
      }
      return $countries;
    } else {
      return null;
    }
  }

?>
