/* Inputs de "Puntos" */

INSERT INTO `puntos` (`id`, `nombre`, `descripcion`, `latitud`, `longitud`, `personal`, `usuario`) VALUES
(1, 'Estació Barceloneta', 'La estación de Barceloneta', 41.382314229601356, 2.185330884454093, 0, NULL),
(2, 'Basílica de Santa Maria del Mar', 'Iglesia gótica del siglo XIV con altísimas columnas, 3 naves y grandes vidrieras.', 41.383948360740280, 2.182037131836704, 0, NULL),
(3, 'Museo del Chocolate', 'Museo con obras de arte famosas elaboradas con chocolate, además de talleres para niños y adultos.', 41.387508917382036, 2.181657540138872, 0, NULL),
(4, 'Paseo de Lluís Companys', 'Paseo de Lluís Companys', 41.389010511649140, 2.183366723193834, 0, NULL),
(5, 'Arco de Triunfo de Barcelona', 'Arco clásico construido como entrada principal a la Exposición Universal que se celebró en la ciudad en 1888.', 41.391207743006380, 2.180658262249682, 0, NULL);

/* Inputs de Etiquetas */
INSERT INTO `etiquetas` (`id`, `nombre`, `color`, `personal`, `usuario`) VALUES
(1, 'Parque', 'Verde', 0, NULL),
(2, 'Catedral', 'Marrón', 0, NULL),
(3, 'Museo', 'Azul', 0, NULL),
(4, 'Monumento', 'Amarillo', 0, NULL),
(5, 'Circo', 'Rojo', 0, NULL);

/* Input de punto_etiquetas */

INSERT INTO `punto_etiquetas` (`id`, `etiqueta`, `punto`, `personal`, `usuario`) VALUES
(1, 1, 1, 0, NULL),
(2, 2, 2, 0, NULL),
(3, 3, 3, 0, NULL),
(4, 4, 4, 0, NULL),
(5, 5, 5, 0, NULL);
