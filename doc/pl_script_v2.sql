/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  08/04/2012 17:29:47                      */
/*==============================================================*/

/* CREATE database project-leader CHARACTER SET utf8 COLLATE utf8_general_ci; */

drop table if exists appartenir;

drop table if exists categorie;

drop table if exists competence;

drop table if exists correspondre;

drop table if exists cv;

drop table if exists demander;

drop table if exists participer;

drop table if exists posseder;

drop table if exists projet;

drop table if exists utilisateur;

/*==============================================================*/
/* Table : appartenir                                           */
/*==============================================================*/
create table appartenir
(
   cat_id_pere          int(8) not null,
   cat_id_fils          int(8) not null,
   primary key (cat_id_pere, cat_id_fils)
);

/*==============================================================*/
/* Table : categorie                                            */
/*==============================================================*/
create table categorie
(
   cat_id               int(8) not null auto_increment,
   cat_libelle          varchar(100),
   cat_description      text,
   primary key (cat_id)
);

/*==============================================================*/
/* Table : competence                                           */
/*==============================================================*/
create table competence
(
   cpt_id               int(8) not null auto_increment,
   cpt_libelle          varchar(100),
   primary key (cpt_id)
);

/*==============================================================*/
/* Table : correspondre                                         */
/*==============================================================*/
create table correspondre
(
   prj_id               int(8) not null,
   cat_id               int(8) not null,
   primary key (prj_id, cat_id)
);

/*==============================================================*/
/* Table : cv                                                   */
/*==============================================================*/
create table cv
(
   cv_id                int(8) not null auto_increment,
   uti_id               int(8) not null,
   cv_lien              varchar(256),
   cv_date              datetime,
   primary key (cv_id)
);

/*==============================================================*/
/* Table : demander                                             */
/*==============================================================*/
create table demander
(
   prj_id               int(8) not null,
   cpt_id               int(8) not null,
   primary key (prj_id, cpt_id)
);

/*==============================================================*/
/* Table : etat                                             */
/*==============================================================*/
create table etat
(
   eta_id               int(8) not null auto_increment,
   eta_libelle          varchar(100),
   eta_date             datetime,
   primary key (eta_id)
);

/*==============================================================*/
/* Table : participer                                           */
/*==============================================================*/
create table participer
(
   prj_id               int(8) not null,
   uti_id               int(8) not null,
   par_date             datetime,
   primary key (prj_id, uti_id)
);

/*==============================================================*/
/* Table : posseder                                             */
/*==============================================================*/
create table posseder
(
   cpt_id               int(8) not null,
   uti_id               int(8) not null,
   primary key (cpt_id, uti_id)
);

/*==============================================================*/
/* Table : projet                                               */
/*==============================================================*/
create table projet
(
   prj_id               int(8) not null auto_increment,
   eta_id               int(8) not null,
   prj_libelle          varchar(100),
   prj_date             datetime,
   prj_budget           int,
   prj_echeance         int,
   prj_description      text,
   primary key (prj_id)
);

/*==============================================================*/
/* Table : utilisateur                                          */
/*==============================================================*/
create table utilisateur
(
   uti_id               int(8) not null auto_increment,
   uti_login            varchar(100),
   uti_statut           varchar(100),
   uti_mail		varchar(100),
   uti_mdp              varchar(40),
   uti_actif            boolean,
   uti_token            varchar(40),
   uti_nom              varchar(100),
   uti_prenom           varchar(100),
   uti_ddn              date,
   uti_adresse          varchar(256),
   uti_cp               varchar(5),
   uti_ville            varchar(100),
   uti_tel              varchar(20),
   uti_presentation     varchar(256),
   uti_date		datetime,
   uti_ddc		datetime,
   primary key (uti_id)
);

alter table appartenir add constraint fk_appartenir foreign key (cat_id_pere)
      references categorie (cat_id) on delete restrict on update restrict;

alter table appartenir add constraint fk_appartenir2 foreign key (cat_id_fils)
      references categorie (cat_id) on delete restrict on update restrict;

alter table correspondre add constraint fk_correspondre foreign key (prj_id)
      references projet (prj_id) on delete restrict on update restrict;

alter table correspondre add constraint fk_correspondre2 foreign key (cat_id)
      references categorie (cat_id) on delete restrict on update restrict;

alter table cv add constraint fk_renseigner foreign key (uti_id)
      references utilisateur (uti_id) on delete restrict on update restrict;

alter table demander add constraint fk_demander foreign key (prj_id)
      references projet (prj_id) on delete restrict on update restrict;

alter table demander add constraint fk_demander2 foreign key (cpt_id)
      references competence (cpt_id) on delete restrict on update restrict;

alter table participer add constraint fk_participer foreign key (prj_id)
      references projet (prj_id) on delete restrict on update restrict;

alter table participer add constraint fk_participer2 foreign key (uti_id)
      references utilisateur (uti_id) on delete restrict on update restrict;

alter table posseder add constraint fk_posseder foreign key (cpt_id)
      references competence (cpt_id) on delete restrict on update restrict;

alter table posseder add constraint fk_posseder2 foreign key (uti_id)
      references utilisateur (uti_id) on delete restrict on update restrict;

alter table projet add constraint fk_etat foreign key (eta_id)
      references etat (eta_id) on delete restrict on update restrict;


INSERT INTO `utilisateur` (`uti_login`, `uti_statut`, `uti_mail`, `uti_mdp`, `uti_nom`, `uti_prenom`, `uti_ddn`, `uti_adresse`, `uti_cp`, `uti_ville`, `uti_tel`, `uti_presentation`, `uti_date`, `uti_ddc`) VALUES
('vyros', 'client', 'vyros', 'vyros', '', '', '0000-00-00', '', '', '', '', '', '2012-04-09 13:12:21', NULL),
('varius', 'prestataire', 'varius', 'varius', '', '', '0000-00-00', '', '', '', '', '', '2012-04-09 18:57:13', NULL);

insert into `etat` (`eta_libelle`) values ('Nouveau'), ('En cours'), ('Fermé'), ('Rejeté');

INSERT INTO `projet` (`eta_id`, `prj_libelle`, `prj_date`, `prj_budget`, `prj_echeance`, `prj_description`) VALUES
(1, 'project-leader', '2012-04-09 13:13:34', 5000, 0, 'site de gestion de projets'),
(1, '12 monkeys', '2012-04-09 23:06:33', 454, 0, '12 monkeys'),
(1, 'machete', '2012-04-09 23:06:35', 454, 0, 'machete'),
(1, 'mr. brooks', '2012-04-09 22:49:18', 300, 0, 'mr. brooks'),
(1, 'bliss', '2012-04-09 23:25:18', 4000, 0, 'bliss'),
(1, 'crash', '2012-04-09 23:36:06', 300, 300, 'crash'),
(2, 'the killer', '2012-04-09 23:39:20', 434, 34, 'the killer'),
(3, 'blade runner', '2012-04-09 23:45:21', 32, 32, 'blade runner'),
(3, 'le diable boiteux', '2012-04-14 23:22:13', 4, 6, 'le diable boiteux'),
(4, 'spaceballs', '2012-04-14 23:31:52', 5, 5, 'spaceballs');

INSERT INTO `participer` (`prj_id`, `uti_id`, `par_date`) VALUES
(1, 1, '2012-04-09 13:13:34'),
(2, 1, '2012-04-09 13:13:40'),
(3, 2, '2012-04-09 22:49:18'),
(4, 1, '2012-04-09 23:06:33'),
(5, 1, '2012-04-09 23:25:18'),
(6, 2, '2012-04-09 23:36:06'),
(7, 1, '2012-04-09 23:41:37'),
(8, 2, '2012-04-09 23:45:21'),
(9, 1, '2012-04-14 23:22:13'),
(10, 2, '2012-04-14 14:17:18');

insert into `competence` (`cpt_libelle`) values ('PHP'), ('Ruby');

INSERT INTO `demander` (`prj_id`, `cpt_id`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 1),
(5, 2),
(6, 2),
(7, 1),
(8, 2),
(9, 1),
(10, 1);

insert into `categorie` (`cat_libelle`) values ('Site internet'), ('Application mobile');

INSERT INTO `correspondre` (`prj_id`, `cat_id`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 1),
(5, 2),
(6, 2),
(7, 1),
(8, 2),
(9, 1),
(10, 1);
