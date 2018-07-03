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
- [ ] colores de grafico no se muestran por añadir '#' en el valor de color de answer
- [x] Añadir Breadcrumb
- [ ] Aumentar tamaño nombre usuario en el grafico
- [ ] Traducir <button>'title' a ingles
- [ ] Después de introducir correo para recuperar contraseña te reenvie a login


## Entities Model
![Entities Model Diagram](http://www.plantuml.com/plantuml/png/ZLJHRze-47xFNt5B7qeaMh9rrNv229LHkY6rwuJONjOAcVWW7ewTsKufclQ_xsm2oQHE-_5Y--wxxpj_vt1b7JEkAcHq2fNAT56WSk1o12aKmXAbte9OmKvNfmQXiaAjWM1bvT30LhWS61XqGZ7WmfQIxOZ9ReGgcM45y5B0HPf6hpYkFE6SBILs52kmoz5c2MIIMGi-0Cn2x8Cn30RGcNTFRcv6z4jWE2JEhLUdZhJaiD86IYCAPdQmGQ-uDeYA6fFQX6obn8yAAS4KfmD7OpDjCEIKTWjLINbiggPQ45NdEO71SlWyw2s7XtnD5b91eH_KF2WS6-21EK0h3wXywvhyDE3OsW9xOa9w3_eK7uZXe2S8GP8is_J7zxVti-61jGjRAiFwKe9gwsqmYzRS5R8EPPhxotQ2PUDnucU0s2U8A_kz7er5-I6Vq-HwmN6qvxxyv4uRZ7B14GfqkUPsVx2EbBNRbMWZuaBbX1D-lvzVPT5q8Vv2ouFg-0M42g_6xgYqIE84VaPjMwVN2Km_pISV9hFew9BH4by8rtPZGLOb2NmTpSOVHxDlRoyV6qp9hDrgmvlqnPjMUYMCTTwdlvHBzb9wZVwX71iAjzuT4U_InoZJbNAcYP7chuCfTOvy6UztPCsji0xq2lOHWVP_EYEiJjeYljVZ-R-qfLeQ_HqpHwgVzxkMQXtvXoZBd7X2U3-Tj_Jvmi-u0MK6cHDQBJXp2DUZ-MG-lPiq1N-QUPcslFQVj16bhsuGhzEKC5AeJRk8hkMVcq4Pn6mkIXlvHk3i30xUzo4UGGZwRy9QiLR87vJJe1KUK75K6-Ch0xWfwuI_BV_uOEslHI6NCmLfyg0oMhCG36pQGA4DGarcu-WA5QyA-Hi0)
