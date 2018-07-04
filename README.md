# Heuristic Evaluation Tool
Heuristic Evaluation Tool is a *Final Degree Project* built with *PHP & MySQL*

## Vision
A web application that allows to perform an heuristic evaluation of the interface of an interactive system.

## Features per Stakeholder

| Evaluator                     | Project Manager                                    | Administrator
| ----------------------------- | -------------------------------------------------- | ----------------------------------------------------- |
| Update his own profile        | Update his own profile                             | Update his own profile                                |
| Make an evaluation            | Make an evaluation                                 | Make an evaluation                                    |
|                               | Create/Update/Delete their own projects            | Create/Update/Delete their own projects               |
|                               | Assign evaluators to their own projects            | Assign evaluators to their own projects               |
|                               | View results of an evaluation                      | Create/Update/Delete Users                            |
|                               | View results and global results of his own project | Modify evaluation template                            |
|                               |                                                    | View results and global results of his own evaluation |
## Tasks
- [x] Core Program
- [x] Send Email to recipient when a new account has been created
- [x] CRUD of Users
- [x] CRUD of Projects
- [x] CRUD of Evaluation Template
- [x] Template Categories
- [x] Template Questions
- [x] Template Answers
- [x] Forgot password
- [x] Start a new Evaluation
- [x] Finish an Evaluation
- [x] Send an Email to project manager when an evaluation is finished
- [x] Update finish date when creating a project
- [x] View results of an Evaluation as a Project Manager
- [x] View results of an own Evaluation
- [x] Unscored answers
- [x] Evaluation Results View
- [x] Activar template una vez finalizada la modificación
- [x] Controlar eliminación/modificación template si esta en uso/abierto para usuarios
- [x] Si esta en el tab Answer modificando valores, mantener la misma pestaña al guardar
- [x] Diseño icono color de answer
- [ ] Cambiar colorpicker
- [x] Poner status a templates
- [ ] importar csv
- [ ] enviar mensaje de activación a todos los usuarios añadidos desde csv
- [ ] dividir pantalla para evaluar
- [x] colores de grafico no se muestran por añadir '#' en el valor de color de answer
- [x] Añadir Breadcrumb
- [ ] Aumentar tamaño nombre usuario en el grafico
- [ ] Traducir <button>'title' a ingles
- [ ] Después de introducir correo para recuperar contraseña te reenvie a login
- [ ] Info para realizar evaluaciones
- [ ] Remove Evaluations when a user is unassigned form a project (?)


## Entities Model
![Entities Model Diagram](http://www.plantuml.com/plantuml/png/hLNVRzis47xNNt5p7s81QQojwpO8Xb7NTRS0QRC5xbwMmg2biys58ZMIYciC-zztf4I9GRrv1UON7U_7z_4-7kbNnZ9jcqea5z38GbKLIWjsZo2uHDYWK0VWMpYgva8ZD8RB7L1QtLZKSE1s3mmqMYuPbDpKWXq9oJnmMJFDAYXh3Y-oBFcgnAq3NB6DmB5a5LwMQ8eK2i6C0US0Pc3ad2EOJc6ykdpszksSVYdCPeHvSEoq8oLAs2eDjUOLqqTuGCUuquWI2YMKzj56yZyQf02J9IrArAPG6drCAhkMZH1XKm5gJL3ZJobCDxDFqybc5k8Tc0zvXjopkII_7183iazjN4BZjgv8JmsMxGomHyQ5qo0d_vJFfXDE6KJ9YeTySNjpUpSBg9Tme3Bick9KsvbUBFhkRIKwLw5Ar-pOIxPOf6GRn9nIR9rF9dGiqXtoLQ6gYLSSpPKhV_PEQKpsl4IeqEvLQTg5iSIixB56an0MIiijTtPxVer1VGcZ3_IvbsFt0Ixzr9WZbLRfA8K_arZMwpSfNBzVBNzStYMzIbe9FE7kvCQAf4fJ-7L-j_XfVlVRjoy_3ZarzN1GkXp2Bxw9mbkkZNKw_KEvOAV2EtI3qc_8TttiCxxFFYQ5QgJLWuyu_mgYT37IPT5Q9CqDDnRK5beFH_CVbU56fJ69ssk__Y6BM6kjViV24klFhHMnTfupfAom_17XzVKguY_Nxeo7f48Zirp9TSaimflvQhcwVhSS2fwA-JABj7PNMlFQLGyPNsSPvGWk7-AYeIryPABnZDJPibz4pGtEC_rHBvr8iSkr5zO3hSMg5imYaQuwCw8ChZE4JelJNGNuTS4ixbGxB9qPyNGkZkSx2uXVGawNotJA_jAP4NbmdUSEJNm9DvFcuD-EkJSYtjRnVtJi1eDczFR3wvjbujx7HlVnx_ocBa2ZQ6TdpskJ-65u_Xp2zSxzszO-kiRmdSJoNbe5IcB86ILXgAZEruUYiVzNT6yRxDoj8PVTCmbPUYyB-XRUwR6KXaffX0xAZC9EWYU0tijeAs0LlEzhhaR9S5cUbaONvpC09NlQ621qSwAwT2MRewzqAKyKw4yb7nwYKvGXRvG4AwuUHYeVBY3icNcYLj5VZu0ILyPmOT8X7-xPPt0XoPpSKnZPVzrHcq80hr2MJIMIlm40)
