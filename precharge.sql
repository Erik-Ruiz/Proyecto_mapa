/* Inputs de "Puntos" */

INSERT INTO `puntos` (`id`, `nombre`, `descripcion`, `latitud`, `longitud`, `personal`, `usuario`) VALUES
(1, 'Estació Barceloneta', 'La estación de Barceloneta', 41.382314229601356, 2.185330884454093, 0, NULL),
(2, 'Basílica de Santa Maria del Mar', 'Iglesia gótica del siglo XIV con altísimas columnas, 3 naves y grandes vidrieras.', 41.383948360740280, 2.182037131836704, 0, NULL),
(3, 'Museo del Chocolate', 'Museo con obras de arte famosas elaboradas con chocolate, además de talleres para niños y adultos.', 41.387508917382036, 2.181657540138872, 0, NULL),
(4, 'Paseo de Lluís Companys', 'Paseo de Lluís Companys', 41.389010511649140, 2.183366723193834, 0, NULL),
(5, 'Arco de Triunfo de Barcelona', 'Arco clásico construido como entrada principal a la Exposición Universal que se celebró en la ciudad en 1888.', 41.391207743006380, 2.180658262249682, 0, NULL);

/* Inputs de Etiquetas */
INSERT INTO `etiquetas` (`id`, `nombre`, `color`, `personal`, `usuario`) VALUES
(1, 'Parque', 'green', 0, NULL),
(2, 'Catedral', 'violet', 0, NULL),
(3, 'Museo', 'blue', 0, NULL),
(4, 'Monumento', 'yellow', 0, NULL),
(5, 'Circo', 'red', 0, NULL);

/* Input de punto_etiquetas */

INSERT INTO `punto_etiquetas` (`id`, `etiqueta`, `punto`, `personal`, `usuario`) VALUES
(1, 1, 1, 0, NULL),
(2, 2, 2, 0, NULL),
(3, 3, 3, 0, NULL),
(4, 4, 4, 0, NULL),
(5, 5, 5, 0, NULL);

INSERT INTO `pruebas` (`nombre`, `texto_pregunta`, `texto_pista`, `respuesta`, `latitud`, `longitud`)
VALUES ('Prueba 1', 'Para empezar esta gimcana, situaros en la escultura \"RUTA EUROPEA DEL MODERNISMO KM 0\" la encontrareis en frente del arco de Triunfo de Barcelona y observareis una estatua a su lado.\r\n\r\nEscriba el nombre de la estatua completando los huecos en blanco:\r\n\r\nP__ C__R_S\r\n', '\r\nDirigiros a la entrada principal de la Exposición Universal de Barcelona de 1888.', 'PAU CLARIS', '41.39104419774112', '2.1806796430455093');

INSERT INTO `pruebas` (`nombre`, `texto_pregunta`, `texto_pista`, `respuesta`, `latitud`, `longitud`)
VALUES ('Prueba 2', 'Escultura en el Paseo de Lluís Companys, en sentido contrario al Arco del Triunfo, al principio de la calle. Sitúate a la altura del parque de la Ciutadella antes de entrar al paseo para poder apreciarla.\r\n\r\nCompleta el nombre y escríbelo para saber la próxima prueba:\r\n\r\nM__UME__O _ R_US Y __U_ET', 'El monumento consta de un pedestal, en cuyos cuatro costados figuran sendos escudos de bronce que representan cuatro de los principales proyectos impulsados por el alcalde: el Parque de la Ciudadela, la Exposición Universal de 1888, el Monumento a Colón y la Gran Vía de las Cortes Catalanas.', 'MONUMENTO A RIUS Y TAULET', '41.38908037524528', '2.18335773445967');

INSERT INTO `pruebas` (`nombre`, `texto_pregunta`, `texto_pista`, `respuesta`, `latitud`, `longitud`)
VALUES ('Pista 3', 'En este museo hay catas de diferentes tipos y diversas actividades dónde todo va al rededor de un ingrediente.\r\n\r\nEn Bulgaría es muy común y podrías encontrar personas pequeñitas preparandolos en según que pelis que empiezan por la letra U.\r\n\r\n¿Sabes a que museo nos referimos ya?', 'No es el museo de Willy Wonka, pero si que comparten algo entre los dos.', 'MUSEO DE CHOCOLATE', '41.387581324695674', '2.181721924437919');
