# Heuristic Evaluation Tool
Heuristic Evaluation Tool is a *Final Degree Project* built with *PHP & MySQL*

## Vision
A web application that allows to perform an heuristic evaluation of the interface of an interactive system.

## Main Features per Stakeholder

| Evaluator                     | Project Manager                                    | Administrator
| ----------------------------- | -------------------------------------------------- | ----------------------------------------------------- |
| Update his own profile        | Update his own profile                             | Update his own profile                                |
| Make an evaluation            | Make an evaluation                                 | Make an evaluation                                    |
|                               | Create/Update/Delete their own projects            | Create/Update/Delete all projects                     |
|                               | Assign evaluators to their own projects            | Assign evaluators to all projects                     |
|                               | View results of an evaluation                      | Create/Update/Delete Users                            |
|                               |                                                    | Modify evaluation template                            |
|                               |                                                    | View results and global results of all evaluations    |
## Checklist
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
- [x] Check if an evaluation is in use before modify or delete
- [x] Keep active Tab on refresh template page
- [x] Color icon design
- [x] Change colorpicker
- [x] Set status on templates
- [x] Import CSV file
- [x] Send and activation email to all imported users
- [x] Bug on value of color (# missing)
- [x] Add breadcrumb to all content
- [x] Enlarge size of user on radar graphs
- [x] Information about how to make evaluations
- [x] Remove Evaluations when a user is unassigned form a project (?)
- [x] Home Content
- [x] Print Reports (maybe using window.print())


## Entities Model
![Entities Model Diagram](http://www.plantuml.com/plantuml/png/hLNVRzis47xNNt5p7s81IUojwpOOXb7NTRS0QRC5xbwMmg2biyM58ZMIYciC-zztf4I9Hhnv1PO7wtW_lk_uySYyDfPfMvSYkO1QPgeiKLgm1OBW4c63Gks1R-6WwWkDK1ikTq1fLMrHmvxR0XXej5mooBcf13iGaddaicAQbP1N75wEnybNEMuTu8fj10ubA_4oHvEba0bc33W7C0C3vnp0T0h3rUMBT-_cz9V2R4QOUyTE7IcHmrPfg3GlcJx08ph6dKQKr9XGsaThoV-eaG9CvhJ8KPjCQVGngUnQraA4fWBKcg26drEORcQVfwFDBCHRC1_o31FFvfByiayCo3wrTWcrQrsHdXeisnbWJumBfy64_5C-cuuuPH0bonudYxlRk_jPGBs4FPLXkobEjQtfnQ9lOKlHkZALkyqElMIBHKgsGPnGYgqcen4TYtI7V4qdD_AAexbsvI_UAur9mNE44csXSjCiZ2LcPGyLceImK5fkkRERywiDwaiOVAJFWnow3t3ffyOSgBHC1odycSIothnDuUR3QldZyZxfLD9Au0btApUM95MQmg_p-yLFy_lVldtrgS-fc35xfVC-_FARABpbsbYdqp-K2tOgl4CtA5r3VjU7BkFxyQSaKxMqklSHvrz1b3P6kYmQYwIvvSQ2saBZuMZ-epBSg3GcSRrswn_64MkbrU-OMMBzkR4YrjPpXfHbbZyXlBbPHVpvsfrndvHfP9OhkSwPHNWxNorND--N2KqzDyMniqSvLlZLE3e0Tyyrhnnad_7rU4mvWil7eo9gnc9P2IBfczPPGLtdhkrU37nYelPzaXxBRX59qZlFg4AahRInouaIrZrjw8v8LwqPKGRN6K8dLhpjv_3hZ7vsgXcnrenuMjVP8Ola_19okfAcLVQNrep8W-iyTzZ4bt0pQVR-nPbx8-9j7F_7ZjrWq13VVNnpkqpSgrhhBlwTR-e2D8fcTWfUcSGFmzKLX4TXub_4vgasXkyavW_IAb0IGyuW2KD5TRu-50tz_rBt8iBEtJLosO996ASFCgDlvfqUIsaebKPeeSmWT18y0VH1Hgs0LV2XgxaU9FrbEIgDByup02KxsXWWxEP4TUvADWTNwLEE5EXEPT8zNoSfGzuW2LPStO_KfB-0K31pf5RMNO-04bS6k7ZIOTBVisTm8ScSx2cCxBzsrAGGm6kKULsAlm40)
