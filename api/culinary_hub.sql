-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20-Jun-2023 às 03:59
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `culinary_hub`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastros`
--

CREATE TABLE `cadastros` (
  `id` int(11) NOT NULL,
  `nome` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `confirmar_senha` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `cadastros`
--

INSERT INTO `cadastros` (`id`, `nome`, `email`, `senha`, `confirmar_senha`) VALUES
(30, 'vinicius', 'adm@gmail.com', 'asd', 'asd'),
(37, 'Livia', 'livia@gmail.com', '123', '123'),
(38, 'vladimir', 'v.barros.nino@gmail.com', '123', '123'),
(39, 'Rafael', 'rafa@gmail.com', '123', '123'),
(40, 'boludo', 'boludo@gmail.com', '123', '123');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `id_receita` int(11) NOT NULL,
  `autor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data_hora` datetime NOT NULL DEFAULT current_timestamp(),
  `comentario` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `id_receita`, `autor`, `data_hora`, `comentario`) VALUES
(144, 106, 'vinicius', '2023-06-19 14:17:39', 'Hamburguer delicioso'),
(145, 112, 'vinicius', '2023-06-19 14:30:29', 'Pizza bacana'),
(147, 105, 'vinicius', '2023-06-19 15:04:30', 'Num gosto de salada'),
(149, 103, 'vinicius', '2023-06-19 15:25:15', 'Bolo muito bom'),
(150, 103, 'Livia', '2023-06-19 22:24:23', 'Receita maravilhosa!!!!!!!'),
(151, 104, 'Livia', '2023-06-19 22:24:38', 'Hmmm salmão grelhado'),
(152, 112, 'Livia', '2023-06-19 22:24:51', 'Pizza gostosa'),
(153, 111, 'vladimir', '2023-06-19 22:29:17', 'MINHA COMIDA FAVORITA!'),
(154, 112, 'vladimir', '2023-06-19 22:29:44', 'Bom comer enquanto jogo lol'),
(155, 112, 'Rafael', '2023-06-19 22:32:06', 'Pizza nigeriana kkk'),
(156, 112, 'boludo', '2023-06-19 22:33:37', 'AMO AMO AMO'),
(157, 114, 'boludo', '2023-06-19 22:35:09', 'AMO'),
(158, 103, 'boludo', '2023-06-19 22:35:18', 'Amo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `favoritar`
--

CREATE TABLE `favoritar` (
  `id_favorito` int(11) NOT NULL,
  `id_fav_usuario` int(11) NOT NULL,
  `id_fav_receita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `favoritar`
--

INSERT INTO `favoritar` (`id_favorito`, `id_fav_usuario`, `id_fav_receita`) VALUES
(134, 37, 103),
(135, 37, 104),
(136, 37, 106),
(137, 37, 111),
(138, 37, 109),
(139, 37, 114),
(140, 30, 103),
(141, 30, 104),
(142, 30, 106),
(143, 30, 107),
(144, 30, 112),
(145, 30, 111),
(146, 30, 110),
(147, 30, 108),
(148, 30, 113),
(149, 30, 114),
(150, 30, 115),
(151, 38, 111),
(152, 39, 103),
(153, 39, 104),
(154, 39, 105),
(155, 39, 106),
(156, 39, 107),
(157, 39, 112),
(158, 39, 111),
(159, 39, 110),
(160, 39, 109),
(161, 39, 108),
(162, 39, 113),
(163, 39, 114),
(164, 39, 115);

-- --------------------------------------------------------

--
-- Estrutura da tabela `receitas`
--

CREATE TABLE `receitas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ingredientes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `modo_preparo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `categoria` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `receitas`
--

INSERT INTO `receitas` (`id`, `titulo`, `descricao`, `ingredientes`, `modo_preparo`, `categoria`, `imagem`) VALUES
(103, 'Bolo de chocolate', 'O bolo de chocolate é uma sobremesa clássica e irresistível que agrada a todos os paladares. Com uma massa fofinha e um sabor intenso de chocolate, esse bolo é perfeito para ocasiões especiais ou simplesmente para satisfazer um desejo por doçura.', '2 xícaras de farinha de trigo 1 xícara de cacau em pó 1 colher de sopa de fermento em pó 1/2 colher de chá de sal 1 3/4 xícaras de açúcar 1/2 xícara de manteiga sem sal, em temperatura ambiente 2 ovos grandes 1 colher de chá de extrato de baunilha 1 1/2 x', 'Pré-aqueça o forno a 180°C. Unte e enfarinhe uma forma redonda de tamanho médio. Em uma tigela grande, peneire a farinha de trigo, o cacau em pó, o fermento em pó e o sal. Reserve. Em outra tigela, bata a manteiga e o açúcar até obter uma mistura cremosa ', 'Sobremesas', 'bolo.jpeg'),
(104, 'Salmão grelhado com molho de limão e dill', 'O salmão grelhado com molho de limão e dill é uma opção saudável, saborosa e repleta de nutrientes. O salmão é grelhado até ficar macio e suculento, e é servido com um delicioso molho de limão e dill, que adiciona um toque refrescante e herbáceo ao prato.', '4 filés de salmão Suco de 1 limão 2 colheres de sopa de azeite de oliva 2 colheres de sopa de dill fresco picado 2 dentes de alho picados Sal e pimenta a gosto', 'Pré-aqueça a grelha em fogo médio-alto. Em uma tigela pequena, misture o suco de limão, o azeite de oliva, o dill picado e o alho picado. Tempere com sal e pimenta a gosto. Coloque os filés de salmão em uma assadeira e regue-os com metade do molho prepara', 'Aperitivos', 'salmao.png'),
(105, 'Salada de quinoa com legumes assados e molho de tahine', 'A salada de quinoa com legumes assados e molho de tahine é uma combinação saudável e saborosa que oferece uma variedade de texturas e sabores. A quinoa é cozida e misturada com legumes assados, como abobrinha, cenoura e pimentão, e é finalizada com um del', '1 xícara de quinoa 2 xícaras de água 1 abobrinha média, cortada em cubos 2 cenouras médias, cortadas em rodelas 1 pimentão vermelho, cortado em tiras 2 colheres de sopa de azeite de oliva Sal e pimenta a gosto 1/4 de xícara de sementes de girassol torrada', 'Pré-aqueça o forno a 200°C. Em uma panela, coloque a quinoa e a água. Leve ao fogo médio e cozinhe por cerca de 15 minutos, ou até que a quinoa esteja macia e os grãos tenham absorvido toda a água. Retire do fogo e deixe esfriar. Enquanto a quinoa cozinha', 'Saladas', 'salada.png'),
(106, 'Hambúrguer gourmet com queijo derretido e cebolas caramelizadas', 'O hambúrguer gourmet com queijo derretido e cebolas caramelizadas é uma opção irresistível para os amantes de hambúrgueres. Com uma carne suculenta, queijo derretido e cebolas caramelizadas macias e doces, esse hambúrguer oferece uma combinação de sabores', '500g de carne moída (pode ser patinho, acém ou fraldinha) 1 colher de chá de sal 1/2 colher de chá de pimenta-do-reino 4 fatias de queijo cheddar (ou outro queijo de sua preferência) 2 cebolas grandes, fatiadas 2 colheres de sopa de manteiga 2 colheres de', 'Em uma tigela, tempere a carne moída com sal e pimenta-do-reino. Misture bem e divida em 4 porções iguais. Modele cada porção em formato de hambúrguer, pressionando levemente para que fiquem compactos. Em uma frigideira ou grelha aquecida, grelhe os hambú', 'Lanches', 'burg.png'),
(107, 'Pudim de pão com baunilha e passas ao rum', 'O pudim de pão com baunilha e passas ao rum é uma sobremesa clássica e reconfortante. Feito com pão amanhecido, leite, ovos, baunilha e passas maceradas em rum, esse pudim adquire uma textura cremosa e um sabor delicado e perfumado. É uma opção deliciosa ', '6 xícaras de pão amanhecido cortado em cubos 2 xícaras de leite 4 ovos 1/2 xícara de açúcar 1 colher de chá de extrato de baunilha 1/2 xícara de passas 1/4 de xícara de rum Manteiga para untar a forma Açúcar de confeiteiro (opcional, para polvilhar)', 'Pré-aqueça o forno a 180°C. Unte uma forma refratária ou assadeira com manteiga. Em uma tigela pequena, coloque as passas e regue com o rum. Deixe as passas macerarem por cerca de 15 minutos para absorverem o sabor. Em uma tigela grande, misture os cubos ', 'Sobremesas', 'pudim.jpeg'),
(108, 'Frango à parmegiana com queijo derretido e molho de tomate caseiro', 'O frango à parmegiana com queijo derretido e molho de tomate caseiro é um prato clássico da culinária italiana que conquista o paladar de muitas pessoas. Nessa receita, filés de frango empanados são cobertos com queijo derretido e um molho de tomate casei', '4 filés de peito de frango Sal e pimenta a gosto Farinha de trigo para empanar 2 ovos batidos Farinha de rosca para empanar Óleo vegetal para fritar 200g de queijo mussarela fatiado Queijo parmesão ralado a gosto Para o molho de tomate: 2 colheres de sopa', 'Tempere os filés de frango com sal e pimenta dos dois lados. Passe cada filé pela farinha de trigo, sacudindo o excesso, mergulhe no ovo batido e empane na farinha de rosca. Pressione levemente para que a farinha de rosca grude bem. Aqueça uma frigideira ', 'Carnes', 'frango2.jpg'),
(109, 'Sopa de tomate assado com manjericão fresco', 'A sopa de tomate assado com manjericão fresco é uma opção reconfortante e cheia de sabor. Nesta receita, os tomates são assados para realçar o seu sabor doce e caramelizado, resultando em uma sopa rica e encorpada. O toque final do manjericão fresco adici', '1 kg de tomates maduros 2 cebolas médias, cortadas em quartos 4 dentes de alho 2 colheres de sopa de azeite de oliva Sal e pimenta a gosto 1 colher de chá de açúcar (opcional, para equilibrar a acidez) 500 ml de caldo de legumes (ou água) Folhas de manjer', 'Pré-aqueça o forno a 200°C. Lave e corte os tomates ao meio. Disponha os tomates cortados, as cebolas e os dentes de alho em uma assadeira. Regue os tomates, as cebolas e o alho com o azeite de oliva. Tempere com sal e pimenta a gosto. Se desejar, polvilh', 'Sopas', 'sopa.jpeg'),
(110, 'Brownies de chocolate com nozes pecan', 'Os brownies de chocolate com nozes pecan são uma delícia irresistível. Com uma casquinha crocante por fora e um interior macio e úmido, esses brownies são uma combinação perfeita de chocolate rico e nozes pecan crocantes. Eles são perfeitos para os amante', '200g de chocolate meio amargo 150g de manteiga sem sal 1 e 1/4 xícara de açúcar 3 ovos 1 colher de chá de extrato de baunilha 3/4 xícara de farinha de trigo 1/4 xícara de cacau em pó 1/4 colher de chá de sal 1 xícara de nozes pecan picadas', 'Pré-aqueça o forno a 180°C. Unte uma forma quadrada ou retangular com manteiga e forre o fundo com papel manteiga. Em banho-maria ou no micro-ondas, derreta o chocolate meio amargo juntamente com a manteiga. Mexa bem até obter uma mistura lisa e homogênea', 'Sobremesas', 'brownie.jpeg'),
(111, 'Acarajé', 'Acarajé é um quitute típico da culinária brasileira, originário da região da Bahia. É um bolinho frito feito de massa de feijão-fradinho recheado com vatapá, caruru, camarão seco e molho de pimenta. É um prato muito apreciado e bastante popular em todo o ', '500g de feijão-fradinho 1 cebola grande 3 dentes de alho Sal a gosto Óleo de dendê (para fritar) Camarão seco Vatapá (mistura feita com camarão seco, amendoim, castanha de caju, pão de forma, leite de coco e temperos) Caruru (uma mistura de quiabo, camarã', 'Deixe o feijão-fradinho de molho em água por pelo menos 4 horas. Escorra a água do feijão e lave bem. Coloque o feijão no liquidificador e adicione a cebola picada, os dentes de alho e o sal. Bata até obter uma massa lisa e homogênea. Se necessário, adici', 'Aperitivos', 'acaraje.jpeg'),
(112, 'Pizza de calabresa', 'A pizza de calabresa é uma deliciosa opção de pizza coberta com molho de tomate, queijo derretido e fatias de calabresa defumada. Ela possui um sabor característico e uma textura crocante, tornando-se uma escolha popular entre os amantes de pizza.', 'Massa para pizza (pode ser comprada pronta ou feita em casa) Molho de tomate Queijo muçarela ralado Calabresa fatiada Azeite de oliva Orégano (opcional) Pimenta calabresa (opcional, para quem gosta de um toque picante)', 'Preaqueça o forno de acordo com as instruções da massa para pizza. Abra a massa em uma superfície ligeiramente enfarinhada, formando um disco no tamanho desejado. Transfira a massa para uma assadeira ou pedra de pizza. Espalhe o molho de tomate sobre a ma', 'Massas', 'pizza2.jpeg'),
(113, 'macarrão ao molho branco', 'O macarrão ao molho branco é um prato que consiste em massa cozida, como espaguete ou fettuccine, coberta por um molho cremoso e suave feito com leite, manteiga e farinha de trigo. O molho branco adiciona uma textura aveludada ao macarrão, tornando-o uma ', '250g de macarrão (espaguete, fettuccine, penne, etc.) 2 colheres de sopa de manteiga 2 colheres de sopa de farinha de trigo 500ml de leite Sal e pimenta a gosto Noz-moscada ralada (opcional) Queijo parmesão ralado (opcional, para finalizar)', 'Cozinhe o macarrão de acordo com as instruções da embalagem, em água fervente com sal. Escorra e reserve. Em uma panela, derreta a manteiga em fogo médio. Adicione a farinha de trigo à manteiga derretida e mexa bem até obter uma mistura homogênea, formand', 'Massas', 'maca.png'),
(114, 'Strogonoff', 'O strogonoff é um prato que consiste em pedaços de carne macia, como frango ou carne bovina, cozidos em um molho cremoso de creme de leite e servidos com arroz branco. O molho é rico em sabores e temperos, proporcionando uma combinação deliciosa com a car', '500g de carne (frango, carne bovina ou outra carne de sua preferência) 1 cebola média picada 2 dentes de alho picados 200g de champignon fatiado (opcional) 3 colheres de sopa de ketchup 2 colheres de sopa de mostarda 1 lata de creme de leite Sal e pimenta', 'Corte a carne em tiras ou cubos pequenos, tempere com sal e pimenta a gosto. Aqueça uma frigideira grande com óleo ou manteiga em fogo médio-alto e adicione a carne. Sele a carne até dourar, mexendo ocasionalmente para garantir que fique cozida por igual.', 'Carnes', 'stro.jpeg'),
(115, 'Lasanha', 'A lasanha é um prato clássico italiano composto por camadas de massa de lasanha pré-cozida, molho de tomate rico e cremoso, recheio de carne ou legumes, queijo e molho bechamel. Essas camadas são montadas em uma assadeira e assadas até que a lasanha fique', '250g de massa de lasanha pré-cozida 500g de carne moída (ou substitua por legumes para uma versão vegetariana) 1 cebola média picada 3 dentes de alho picados 500ml de molho de tomate Sal e pimenta a gosto 250g de queijo muçarela ralado 100g de queijo parm', '50g de manteiga 50g de farinha de trigo 500ml de leite Sal, pimenta e noz-moscada a gosto', 'Massas', 'lasanha.jpeg');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cadastros`
--
ALTER TABLE `cadastros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices para tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `fk_receita` (`id_receita`),
  ADD KEY `autor` (`autor`);

--
-- Índices para tabela `favoritar`
--
ALTER TABLE `favoritar`
  ADD PRIMARY KEY (`id_favorito`),
  ADD KEY `fk_fav_receita` (`id_fav_receita`),
  ADD KEY `fk_fav_usuario` (`id_fav_usuario`);

--
-- Índices para tabela `receitas`
--
ALTER TABLE `receitas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cadastros`
--
ALTER TABLE `cadastros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT de tabela `favoritar`
--
ALTER TABLE `favoritar`
  MODIFY `id_favorito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT de tabela `receitas`
--
ALTER TABLE `receitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `cadastros` (`nome`),
  ADD CONSTRAINT `fk_receita` FOREIGN KEY (`id_receita`) REFERENCES `receitas` (`id`);

--
-- Limitadores para a tabela `favoritar`
--
ALTER TABLE `favoritar`
  ADD CONSTRAINT `fk_fav_receita` FOREIGN KEY (`id_fav_receita`) REFERENCES `receitas` (`id`),
  ADD CONSTRAINT `fk_fav_usuario` FOREIGN KEY (`id_fav_usuario`) REFERENCES `cadastros` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
