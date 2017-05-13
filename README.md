# sql-query-library

Pequena lib de comandos sql para simplificar conexões com o mysql.
<br/>
Opera apenas com um banco de dados e schema por vez, logo é indicada para websites simples que operem apenas uma base de dados por vez.

<ul>
  <li><a href="#download">Download</a></li>
  <li><a href="#utilization">Utilização</a></li>
  <li><a href="#functions">Funções</a></li>
</ul>

<h2 id="download">Download</h2>

Composer - Apenas é necessário incluir no require : "gallahaaz/sql-query-library": "dev-master"

<h2 id="utilization">Utilização</h2>

A conexão é simples , apenas sendo necessário configurar as seguintes constantes
<p><strong>DBHOST</strong> - Host do servidor, que pode ser local ou remoto</p>
<p><strong>DBLOGIN</strong> - Login de acesso ao servidor mysql</p>
<p><strong>DBPASSWORD</strong> - Senha de acesso ao servidor mysql
<p><strong>DBSCHEMA</strong> - Schema alvo do servidor</p>
<br/>
Após a configuração, apenas é necessário utilizar use Gallahaaz\SqlQueryLibrary\Query e instanciar o objeto em uma variável.
<br/>
<h2 id="functions">Funções</h2>
<br/>
<h3>query( $command )</h3> - Realiza qualquer comando $command(string) sql informado
<br/>
<h3>getLastId()</h3> - Retorna o id do ultimo insert executado (return int)
<br/>
<h3>fetch( $result, $method = MYSQLI_BOTH, $index = null )</h3> - Realiza o fetch de qualquer resultado de query() passado através de $result, atribuindo os valores a um array. $method(string) pode ser alterada na chamada da função para que o retorno seja apenas numérico ou associativo.
<br/>A função retorna os resultados em uma matriz tridimensional indexada numericamente, seguida pelos campos selecionados através do $method, caso $index(string) não seja definida.
<br/>Se $index(string) for definida, o index primário do campo será relacionado aos valores indexados na no retorno da mysqli->fetch_array.
<br/>
<h3>fetchDecode( $result, $method = MYSQLI_BOTH, $index = null )</h3> - Opera identicamente a fetch, apenas aplicando url_decode no retorno dos valores vindos do banco de dados.
<br/>
<h3>fetchSingle( $result, $method = MYSQLI_BOTH )</h3> - Realiza o fetch e retorna o último valor do resultado da query. Asim como o nome sugere, é indicado para buscas com resultado único.
<br/>
<h3>select( $fields, $table, $searchFields=null, $options=null )</h3> - Realiza o comando select. $fields(array) define quais campos serão buscados através de um array contendo os nomes dos campos da tabela a serem pesquisados. Exemplos :
<ul>
  <li>$fields = ['nome', 'email'];</li>
  <li>$fields = ['DISTINCT nome'];</li>
  <li>$fields = ['DISTINCT nome','email'];</li>
  <li>$fields = ['COUNT(DISTINCT Country)'];</li>
</ul>
$table(string) define qual a tabela que deverá ser pesquisada.
$searchFields(matriz) recebe os valores que serão usados de filtro no select. Exemplos :
<ul>
  <li>$searchFields = [
    'nome' => 'joão',
    'email' => 'email@email.com'
  ];</li>
  <li>$searchFields = [ 'id' = 1 ];</li>
</ul>
$options(string) recebe uma string que pode conter qualquer comando sql posterior ao SELECT * FROM table WHERE data=data ($options)
<br/>
<h3>insert( $table, $columns, $values)</h3> - Realiza uma inserção na tabela $table(string) nas $columns(array) dos $values(array).
Ex :
<br/>
$table = 'user';
<br/>
$columns = ['nome','email','username'];
<br/>
$values = ['Kevin G', 'email@email.com', 'gallahaaz' ];
<br/>
$sql-query-library-object->insert($table, $columns, $values);
<br/>
<h3>update( $table, $set, $where )</h3> - Realiza uma operação de atualização no banco de dados. Atualiza $table com dados de $set em $where. Ex :
$table = 'user';
<br/>
$set = [
<br/>  'nome' => 'Arthur',
<br/>  'email' => 'arthur@email.com'
];

<br/>
$values = ['Kevin G', 'email@email.com', 'gallahaaz' ];
<br/>
$sql-query-library-object->update($table, $columns, $values);
<br/>
<h3>delee( $table, $where )</h3> - Realiza uma operação de exclusão no banco de dados.
