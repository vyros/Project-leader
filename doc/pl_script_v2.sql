/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  08/04/2012 17:29:47                      */
/*==============================================================*/

/* CREATE database project-leader CHARACTER SET utf8 COLLATE utf8_general_ci; */

drop table if exists appertenir;

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
/* Table : appertenir                                           */
/*==============================================================*/
create table appertenir
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
   uti_mail				varchar(100),
   uti_mdp              varchar(256),
   uti_nom              varchar(100),
   uti_prenom           varchar(100),
   uti_ddn              date,
   uti_adresse          varchar(256),
   uti_cp               varchar(5),
   uti_ville            varchar(100),
   uti_tel              varchar(20),
   uti_presentation     varchar(256),
   uti_date				datetime,
   uti_ddc				datetime,
   primary key (uti_id)
);

alter table appertenir add constraint fk_appertenir foreign key (cat_id_pere)
      references categorie (cat_id) on delete restrict on update restrict;

alter table appertenir add constraint fk_appertenir2 foreign key (cat_id_fils)
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

insert into categorie (cat_libelle) values ('Site internet'), ('Application mobile');

insert into competence (cpt_libelle) values ('PHP'), ('Ruby');
