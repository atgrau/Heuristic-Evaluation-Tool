<?php

  /**
   * Countries Model
   */
  class Country
  {
    private $iso;
    private $name;

    function __construct($iso, $name) {
      $this->iso = $iso;
      $this->name = $name;
    }

    function getIso() {
      return $this->iso;
    }

    function getName() {
      return $this->name;
    }
  }

  function getCountryByIso($iso) {
    $country = DB::queryFirstRow("SELECT iso, name FROM countries WHERE iso=%s", $iso);
    if ($account) {
      return new Country($country["iso"], $country["name"]);
    } else {
      return null;
    }
  }

  function countryExists($iso) {
    DB::query("SELECT iso, name FROM countries WHERE iso=%s", $iso);
    return DB::count() > 0;
  }

  function getCountries() {
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
