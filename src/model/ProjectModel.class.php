<?phpequire_once(BASE_URI."controller/ProjectController.class.php");
  require_once(BASE_URI."config/database.php");

  /**
   *
   */
  class ProjectModel
  {
    private $Id;
    private $IdOwnerUser;
    private $CreationDate;
    private $Name;
    private $Description;
    private $Link;

    function __construct($id, $idOwnerUser, $creationDate, $name, $description, $link) {
      $this->Id = $id;
      $this->IdOwnerUser = $idOwnerUser;
      $this->CreationDate = $creationDate;
      $this->Name = $name;
      $this->Description = $description;
      $this->Link = $link;
    }

    function GetId() {
      return $this->Id;
    }

    function GetIdOwnerUser() {
      return $this->IdOwnerUser;
    }

    function GetCreationDate() {
      return $this->CreationDate;
    }

    function GetName() {
      return $this->Name;
    }

    function GetDescription() {
      return $this->Description;
    }

    function GetLink() {
      return $this->Link;
    }

  }

?>
