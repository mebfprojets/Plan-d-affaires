/* ADMINS */
insert into permissions(name, libelle, slug, guard_name) values('admins.index', 'Lister les utilisateurs', 'lister_les_utilisateurs', 'admin');
insert into permissions(name, libelle, slug, guard_name) values('admins.add', 'Ajouter un utilisateur', 'ajouter_un_utilisateur', 'admin');
insert into permissions(name, libelle, slug, guard_name) values('admins.edit', 'Modifier un utilisateur', 'modifier_un_utilisateur', 'admin');
insert into permissions(name, libelle, slug, guard_name) values('admins.delete', 'Supprimer un utilisateur', 'supprimer_un_utilisateur', 'admin');

/* ROLES */
insert into permissions(name, libelle, slug, guard_name) values('roles.index', 'Lister les rôles', 'lister_les_roles', 'admin');
insert into permissions(name, libelle, slug, guard_name) values('roles.add', 'Ajouter un rôle', 'ajouter_un_role', 'admin');
insert into permissions(name, libelle, slug, guard_name) values('roles.edit', 'Modifier un rôle', 'modifier_un_role', 'admin');
insert into permissions(name, libelle, slug, guard_name) values('roles.delete', 'Supprimer un rôle', 'supprimer_un_role', 'admin');

/* PERMISSIONS */
insert into permissions(name, libelle, slug, guard_name) values('permissions.index', 'Lister les permissions', 'lister_les_permissions', 'admin');
insert into permissions(name, libelle, slug, guard_name) values('permissions.add', 'Ajouter un permission', 'ajouter_un_permissions', 'admin');
insert into permissions(name, libelle, slug, guard_name) values('permissions.edit', 'Modifier un permission', 'modifier_un_permissions', 'admin');
insert into permissions(name, libelle, slug, guard_name) values('permissions.delete', 'Supprimer un permission', 'supprimer_un_permissions', 'admin');

/* PARAMETRES */
insert into permissions(name, libelle, slug, guard_name) values('parametres.index', 'Lister les paramètres', 'lister_les_parametres', 'admin');
insert into permissions(name, libelle, slug, guard_name) values('parametres.add', 'Ajouter un paramètre', 'ajouter_un_role', 'admin');
insert into permissions(name, libelle, slug, guard_name) values('parametres.edit', 'Modifier un paramètre', 'modifier_un_role', 'admin');
insert into permissions(name, libelle, slug, guard_name) values('parametres.delete', 'Supprimer un paramètre', 'supprimer_un_role', 'admin');

/* VALEURS */
insert into permissions(name, libelle, slug, guard_name) values('valeurs.index', 'Lister les valeurs', 'lister_les_valeurs', 'admin');
insert into permissions(name, libelle, slug, guard_name) values('valeurs.add', 'Ajouter un valeur', 'ajouter_un_valeur', 'admin');
insert into permissions(name, libelle, slug, guard_name) values('valeurs.edit', 'Modifier un valeur', 'modifier_un_valeur', 'admin');
insert into permissions(name, libelle, slug, guard_name) values('valeurs.delete', 'Supprimer un valeur', 'supprimer_un_valeur', 'admin');

/* MONITORING */
insert into permissions(name, libelle, slug, guard_name) values('admin.monitoring', 'Lister les monitorings', 'lister_les_monitorings', 'admin');

/* LOGS */
insert into permissions(name, libelle, slug, guard_name) values('admin.logs', 'Lister les logs', 'lister_les_logs', 'admin');
