PGDMP                      {            KONECTA_Cafeteria    16rc1    16rc1     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    16398    KONECTA_Cafeteria    DATABASE     �   CREATE DATABASE "KONECTA_Cafeteria" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Spain.1252';
 #   DROP DATABASE "KONECTA_Cafeteria";
                postgres    false            �           0    0    DATABASE "KONECTA_Cafeteria"    COMMENT     G   COMMENT ON DATABASE "KONECTA_Cafeteria" IS 'Base de datos de KONECTA';
                   postgres    false    4792            �            1259    16427 	   Productos    TABLE     U  CREATE TABLE public."Productos" (
    "ID" integer NOT NULL,
    "NombreProducto" character varying(255) NOT NULL,
    "Referencia" character varying(255) NOT NULL,
    "Precio" integer NOT NULL,
    "Peso" integer NOT NULL,
    "Categoria" character varying(255) NOT NULL,
    "Stock" integer NOT NULL,
    "FechaCreacion" date NOT NULL
);
    DROP TABLE public."Productos";
       public         heap    postgres    false            �            1259    16426    Productos_ID_seq    SEQUENCE     �   CREATE SEQUENCE public."Productos_ID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public."Productos_ID_seq";
       public          postgres    false    216            �           0    0    Productos_ID_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public."Productos_ID_seq" OWNED BY public."Productos"."ID";
          public          postgres    false    215            �            1259    16442    VentasProductos    TABLE     �   CREATE TABLE public."VentasProductos" (
    "NombreProducto" character varying(255) NOT NULL,
    "Cantidad" integer NOT NULL,
    "FechaVenta" date NOT NULL
);
 %   DROP TABLE public."VentasProductos";
       public         heap    postgres    false                       2604    16430    Productos ID    DEFAULT     r   ALTER TABLE ONLY public."Productos" ALTER COLUMN "ID" SET DEFAULT nextval('public."Productos_ID_seq"'::regclass);
 ?   ALTER TABLE public."Productos" ALTER COLUMN "ID" DROP DEFAULT;
       public          postgres    false    215    216    216            �          0    16427 	   Productos 
   TABLE DATA           �   COPY public."Productos" ("ID", "NombreProducto", "Referencia", "Precio", "Peso", "Categoria", "Stock", "FechaCreacion") FROM stdin;
    public          postgres    false    216          �          0    16442    VentasProductos 
   TABLE DATA           W   COPY public."VentasProductos" ("NombreProducto", "Cantidad", "FechaVenta") FROM stdin;
    public          postgres    false    217   �       �           0    0    Productos_ID_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public."Productos_ID_seq"', 6, true);
          public          postgres    false    215                        2606    16434    Productos Productos_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public."Productos"
    ADD CONSTRAINT "Productos_pkey" PRIMARY KEY ("ID");
 F   ALTER TABLE ONLY public."Productos" DROP CONSTRAINT "Productos_pkey";
       public            postgres    false    216            �   �   x�m��
�0E盯�T�iRuM:�YtpqI�@M���7�
�p�y�
��ܿF;���iID����Ϋ�N%ՌC�����Ds�i�f��[~�
*��˳z(�/d¿��[�N'�)u��Eg���	�u��$ZcX
m����dl�9W�
��ǎ1��O:<      �   \   x�s��O�/*J���4�4202�5��50�rF���7Bw��UH��\NS�ɉ���9���Ĉ��+8'�d�敤�Z�_6F��� �~5�     