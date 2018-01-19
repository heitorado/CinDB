SELECT professores.idprofessor, 
       professores.nome, 
       (SELECT group_concat(cadeiras.nome separator ', ')
          FROM cadeiras, professores_has_cadeiras
         WHERE professores_idprofessor = idprofessor
           AND idcadeiras = cadeiras_idcadeiras
         ) AS cadeiras
FROM professores
where idprofessor = 9;

-- ALL EXERCICIOS
SELECT distinct idexercicios, 
	   image, 
	   enunciado, 
       professores.nome AS professor, 
       cadeiras.nome AS cadeira, 
	   (SELECT group_concat(tags.nome separator ', ')
          FROM tags, exercicios_has_tags
         WHERE exercicios_idexercicios = idexercicios
           AND idtags = tags_idtags
	   ) AS tags
  FROM exercicios, professores, cadeiras, exercicios_has_tags
 WHERE professores_has_cadeiras_professores_idprofessor = professores.idprofessor
   AND professores_has_cadeiras_cadeiras_idcadeiras = cadeiras.idcadeiras
   AND cadeiras.idcadeiras = 1;
  
  
  SELECT distinct idexercicios, 
	   image, 
	   enunciado, 
       professores.nome AS professor, 
       cadeiras.nome AS cadeira, 
	   (SELECT group_concat(tags.nome separator ', ')
          FROM tags, exercicios_has_tags
         WHERE exercicios_idexercicios = idexercicios
           AND idtags = tags_idtags
	   ) AS tags
  FROM exercicios, professores, cadeiras, exercicios_has_tags, tags
 WHERE professores_has_cadeiras_professores_idprofessor = professores.idprofessor
   AND professores_has_cadeiras_cadeiras_idcadeiras = cadeiras.idcadeiras
   AND cadeiras.idcadeiras = 1
   AND exercicios_idexercicios = idexercicios
           AND idtags = tags_idtags
           AND idtags IN (1);
           
           
-- CADEIRAS E TAGS
SELECT * FROM cadeiras;
SELECT * FROM tags;

SELECT * FROM cadeiras_has_tags;

SELECT idtags, tags.nome 
FROM tags, cadeiras_has_tags
WHERE tags.idtags = cadeiras_has_tags.tags_idtags
  AND cadeiras_has_tags.cadeiras_idcadeiras = 1;
   
  

   

