# pca-helper

Objectif:
1. simplifier la configuration de PHP-CRUD-API
2. Avoir une référence pour le vocabulaire de PHP-CRUD-API (middleware, config)

Piste : créer un tableau simplifié de config

```[
// EXISTANTS
// *********
// Cas 1 : configuration de base (db, cache, ...)
key1=>value
// Cas 2 : middleware avec key1 (nom du middleware)
key1.key2=>value,    // key2 : propriété
key1.ley2=>function, // key2 : function

// PROPOSITIONS

// Cas 1.1, grouper les propriétés de la config de base
// IMPLEMENTE DANS PCA-HELPER
BaseConfig::db(username, password, driver, database, ...)
BaseConfig::cache (cacheTyoe, ...)

// Cas 2.1 : fonction (ou tableau) externe middleware 
key1.key2=AClass::middlewareFunction(operation, request, ...)) // ou tableau

// Cas 2.2 : fonction (ou tableau) externe et INLUS dans la définition du middleeware
key1.key2=function (operation, ...) {
    AClass::middlewareFunction2(operation, request, ...)) // ou tableau
}

// Cas 2.3 : fonction (ou tableau) externe TOTALEMENT INLUS dans la configuration
// IMPLEMENTE DANS PCA-HELPER
new AClass(parameters) // ou AClass::instance(parameters)

```