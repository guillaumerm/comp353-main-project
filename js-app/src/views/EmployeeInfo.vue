<template>
<v-content>
    <h1>Work Schedule</h1>
    <table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Start-time</th>
            <th>End-time</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(day, index) in schedule" :key="index">
            <td>{{day.date}}</td>
            <td>{{day.start_time}}</td>
            <td>{{day.end_time}}</td>
        </tr>
    </tbody>
</table>

    <h1>Payroll</h1>
    <table>
    <thead>
        <tr>
            <th>Year</th>
            <th>Month</th>
            <th>Pay</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(pay, index) in pays" :key="index">
            <td>{{pay.year}}</td>
            <td>{{pay.month}}</td>
            <td>{{pay.pay}}</td>
        </tr>
    </tbody>
</table>

    <h1>Financial Reports</h1>
    <table>
    <thead>
        <tr>
            <th>Report</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(aReport, index) in report" :key="index">
            <td>{{aReport.title}}</td>
            <td>{{aReport.value}}</td>
        </tr>
    </tbody>
</table>
</v-content>

  
  
</template>

<script>
  import EmployeeService from '@/services/EmployeeService.js'

  export default {
    created() {
        EmployeeService.employeeGetSchedule().then(
                (response) => {
                    this.schedule = response.data
                }
            ).catch(
                (error) => {
                    console.error(error)
                }
            )

        EmployeeService.employeeGetPays().then(
            (response) => {
                this.pays = response.data
            }
        ).catch(
            (error) => {
                console.error(error)
            }
        )

        EmployeeService.employeeGetFinancialReport().then(
            (response) => {
                this.report = response.data
            }
        ).catch(
            (error) => {
                console.log(error)
            }
        )
    },
    data: () => ({
      schedule: null,
      report: null,
      pays: null
    })
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

