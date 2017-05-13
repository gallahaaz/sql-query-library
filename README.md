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
<h3>query( $command )</h3> - Realiza qualquer comando sql informado
<br/>
<h3>getLastId()</h3> - Retorna o id do ultimo insert executado
<br/>
<h3>fetch( $result, $method = MYSQLI_BOTH, $index = null )</h3> - Realiza o fetch de qualquer resultado de $query, atribuindo o resultado a um array. $method pode ser alterada na chamada da função para que o retorno seja apenas numérico ou associativo. 
<br/>A função retorna os resultados em uma matriz tridimensional indexada numericamente, seguida pelos campos selecionados através do $method.
<br/>Se $index for definida, o index primário do campo será relacionado aos valores indexados na no retorno da mysqli->fetch_array.
<br/>
<h3>fetchDecode</h3> - Opera identicamente a fetch, apenas aplicando url_decode no retorno dos valores vindos do banco de dados.
<br/>
<h3>fetchSingle( $result, $method = MYSQLI_BOTH )</h3> - Realiza o fetch e retorna o último valor do resultado da query. Asim como o nome sugere, é indicado para buscas com resultado único.
<br/>
