<template>
<v-content>
    <table>
    <thead>
        <tr>
            <th>EMP_ID</th>
            <th>Date</th>
            <th>Start-time</th>
            <th>End-time</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1234</td>
            <td>12/NOV/18</td>
            <td>9:00</td>
            <td>17:00</td>
        </tr>
        <tr>
            <td>1123</td>
            <td>12/NOV/18</td>
           <td>9:00</td>
            <td>17:00</td>
        </tr>
        <tr>
            <td>12322</td>
            <td>12/NOV/18</td>
            <td>9:00</td>
            <td>17:00</td>
        </tr>
        <tr>
            <td>2341</td>
            <td>12/NOV/18</td>
           <td>9:00</td>
            <td>17:00</td>
        </tr>
    </tbody>
</table>

<h1>SCHEDULE VACATION</h1>
 <v-container grid-list-md>
    <v-layout row wrap>
      <v-flex xs12 lg6>
        <v-card color = "grey lighten-1" >
        <v-menu 
          v-model="menu1"
          :close-on-content-click="false"
          full-width
          max-width="290" >
          <v-text-field
            slot="activator"
            :value="computedDateFormattedMomentjs"
            clearable
            readonly
          ></v-text-field>
          <v-date-picker
            v-model="date"
            @change="menu1 = false"
          ></v-date-picker>
        </v-menu>
        </v-card>
      </v-flex>

      <v-flex xs12 lg6>
        <v-card color = "grey lighten-1">
        <v-menu
          v-model="menu2"
          :close-on-content-click="false"
          full-width
          max-width="290"
        >
          <v-text-field
            slot="activator"
            :value="computedDateFormattedDatefns"
            clearable
            readonly
          ></v-text-field>
          <v-date-picker
            v-model="date"
            @change="menu2 = false"
          ></v-date-picker>
        </v-menu>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>

  <div class = "button">
    <button class="pulse">PLAN VACATION</button>
  </div>
  </v-content>

  
  
</template>

<script>
  import HelloWorld from '../components/HelloWorld'
  import moment from 'moment'
  import format from 'date-fns/format'

  export default {
    data: () => ({
      date: new Date().toISOString().substr(0, 10),
      menu1: false,
      menu2: false
    }),
    computed: {
      computedDateFormattedMomentjs () {
        return this.date ? moment(this.date).format('dddd, MMMM Do YYYY') : ''
      },
      computedDateFormattedDatefns () {
        return this.date ? format(this.date, 'dddd, MMMM Do YYYY') : ''
      }
    }
  }
</script>

<style scoped>

@import url(https://fonts.googleapis.com/css?family=Patua+One|Open+Sans);
* {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}


h1 {
  color: #d1e8e2;
  text-align: center;
}

body {
  background: #2c3531;
  display: flex;
}

table {
  border-collapse: separate;
  background: #fff;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
  margin: 50px auto;
  -moz-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
  -webkit-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
  box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
}

thead {
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
}

thead th {
  font-family: 'Patua One', cursive;
  font-size: 16px;
  font-weight: 400;
  color: #fff;
  text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.5);
  text-align: left;
  padding: 20px;
  background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4gPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJncmFkIiBncmFkaWVudFVuaXRzPSJvYmplY3RCb3VuZGluZ0JveCIgeDE9IjAuNSIgeTE9IjAuMCIgeDI9IjAuNSIgeTI9IjEuMCI+PHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzY0NmY3ZiIvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iIzRhNTU2NCIvPjwvbGluZWFyR3JhZGllbnQ+PC9kZWZzPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
  background-size: 100%;
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #646f7f), color-stop(100%, #4a5564));
  background-image: -moz-linear-gradient(#646f7f, #4a5564);
  background-image: -webkit-linear-gradient(#646f7f, #4a5564);
  background-image: linear-gradient(#646f7f, #4a5564);
  border-top: 1px solid #858d99;
}
thead th:first-child {
  -moz-border-radius-topleft: 5px;
  -webkit-border-top-left-radius: 5px;
  border-top-left-radius: 5px;
}
thead th:last-child {
  -moz-border-radius-topright: 5px;
  -webkit-border-top-right-radius: 5px;
  border-top-right-radius: 5px;
}

tbody tr td {
  font-family: 'Open Sans', sans-serif;
  font-weight: 400;
  color: #5f6062;
  font-size: 13px;
  padding: 20px 20px 20px 20px;
  border-bottom: 1px solid #e0e0e0;
}

tbody tr:nth-child(2n) {
  background: #f0f3f5;
}

tbody tr:last-child td {
  border-bottom: none;
}
tbody tr:last-child td:first-child {
  -moz-border-radius-bottomleft: 5px;
  -webkit-border-bottom-left-radius: 5px;
  border-bottom-left-radius: 5px;
}
tbody tr:last-child td:last-child {
  -moz-border-radius-bottomright: 5px;
  -webkit-border-bottom-right-radius: 5px;
  border-bottom-right-radius: 5px;
}

tbody:hover > tr td {
  filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
  opacity: 0.5;
  /* uncomment for blur effect */
  /* color:transparent;
  @include text-shadow(0px 0px 2px rgba(0,0,0,0.8));*/
}

tbody:hover > tr:hover td {
  text-shadow: none;
  color: #2d2d2d;
  filter: progid:DXImageTransform.Microsoft.Alpha(enabled=false);
  opacity: 1;
}

.pulse:hover,
.pulse:focus {
  -webkit-animation: pulse 1s;
          animation: pulse 1s;
  box-shadow: 0 0 0 2em rgba(255, 255, 255, 0);
}

@-webkit-keyframes pulse {
  0% {
    box-shadow: 0 0 0 0 var(--hover);
  }
}

@keyframes pulse {
  0% {
    box-shadow: 0 0 0 0 var(--hover);
  }
}

.pulse {
  --color: #D9B08c;
  --hover: #ef8f6e;
}


button {
  color: var(--color);
  transition: 0.25s;
}
button:hover, button:focus {
  border-color: var(--hover);
  color: #fff;
}

button {
  background: none;
  border: 2px solid;
  font-size: 1em;
  line-height: 1;
  margin: 0.5em;
  padding: 1em 2em;
}

.button{
  text-align: center;
}
</style>

