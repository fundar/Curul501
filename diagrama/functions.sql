CREATE OR REPLACE FUNCTION update_votaciones_representantes()
RETURNS TABLE (text varchar) AS

$$
DECLARE
records RECORD;
count_records float;
text varchar;

BEGIN
	--Ciclo con todos los representantes actuales
	FOR records IN EXECUTE 'select id_representative,full_name from representatives_scrapper' LOOP
		--Actualizo representantes en las votaciones agregando el id_representative del registro acutal del ciclo donde el nombre sea el mismo
		update votaciones_representantes_scrapper set id_representative=records.id_representative where lower(nombre)='''||lower(records.full_name)||''';
		
		--Notice
		RAISE NOTICE 'Nombre: %',records.full_name;
		
		--Query result
		--text:= ''||records.full_name;
		--RETURN QUERY select text;
    END LOOP;
    
    text:= 'TRUE';
	RETURN QUERY select text;
END;
$$
LANGUAGE plpgsql;
