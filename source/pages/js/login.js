'use-strict'
const ele = document.getElementById('trpro')
const table = document.querySelector('.table')
const elediv = document.querySelector('.newpro')
const actulizar = document.querySelector('.botonnuevoguardaractu')
const datos = {
  descripcion: '',
  nombre: '',
  id: ''
}


actulizar.addEventListener('click', (e) => {


  let actuli = document.querySelector('.actulizarproform')



  fetch('../cotrollador/actulizarproducto.php', {
    method: 'POST',
    headers: {
      "content-type": "application/json"

    },

    mode: 'cors',
    cache: 'no-cache',
    body: JSON.stringify({ nombre: datos.nombre, descripcion: datos.descripcion, id: datos.id })
  })
  actuli.style.display = 'none'
  traer()

})


const cancelarHandler = (actuli) => {
  actuli.style.display = 'none'
}









const inputdes = document.querySelector('.nombreact')
const inputnombre = document.querySelector('.descripcionact')


inputdes.addEventListener('change', (e) => {
  datos.nombre = e.target.value
})

inputnombre.addEventListener('change', (e) => {
  datos.descripcion = e.target.value
})


const traer = () => {
  fetch('../cotrollador/traerproducto.php').then(response => response.json()).then(data => {


    ele.innerHTML = ''

    data.map((dat, key) => {


      let ar = Object.keys(dat)
      let newele = document.createElement('tr')
      let fragmento = document.createDocumentFragment()
      for (let i = 0; i < Object.keys(dat).length; i++) {

        if (i == 0) {
          let eletd = document.createElement('td')
          eletd.textContent = dat.id
          fragmento.appendChild(eletd)

        } else if (i == 1) {
          let eletd = document.createElement('td')
          eletd.textContent = dat.nombre

          eletd.addEventListener('input', (e) => {
            datos[ar[1]] = e.target.textContent

          })
          fragmento.appendChild(eletd)
        } else if (i == 2) {
          let eletd = document.createElement('td')
          eletd.textContent = dat.descripcion
          eletd.addEventListener('input', (e) => {
            datos[ar[2]] = e.target.textContent

          })

          fragmento.appendChild(eletd)
        }

      }
      let tdboton = document.createElement('td')
      let divboton = document.createElement('div')
      let eliminar = document.createElement('button')

      let editar = document.createElement('button')
      tdboton.classList.add('tdboton')
      divboton.classList.add('divboton')
      eliminar.classList.add('eliminar')
      editar.classList.add('editar')
      eliminar.textContent = 'eliminar'
      editar.textContent = 'actualizar'
      editar.classList.add(`editar${key}`)



      tdboton.appendChild(divboton)
      divboton.appendChild(eliminar)
      divboton.appendChild(editar)
      fragmento.appendChild(tdboton)
      newele.appendChild(fragmento)

      ele.appendChild(newele)
      let ka = document.querySelector(`.editar${key}`)
      ka.addEventListener('click', () => {


        let cancelar = document.querySelector('.botonnuevocancelaractu')
        let actuli = document.querySelector('.actulizarproform')
        datos.id = dat.id

        inputdes.value = dat.nombre
        inputnombre.value = dat.descripcion
        datos.nombre = dat.nombre
        datos.descripcion = dat.descripcion

        actuli.style.display = 'flex'
        //let descripcion = document.querySelector('.descripcionact').value




        cancelar.addEventListener('click', () => cancelarHandler(actuli))
      });


      eliminar.addEventListener('click', () => {
        fetch('../cotrollador/eliminarproducto.php', {
          method: 'POST',
          headers: {
            "content-type": "application/json"

          },

          mode: 'cors',
          cache: 'no-cache',
          body: JSON.stringify({ id: dat.id })
        }).then(() => {
          traer()
        })
      })


    });



  }).catch(Error => console.log(Error))
}



const bo = document.querySelector('.botonnuevo')
bo.addEventListener('click', () => {
  const nu = document.querySelector('.nuevo')
  console.log(nu)
  nu.style.display = 'block'


})

let guardar = document.querySelector('.botonnuevoguardar')
let form = document.querySelector('.formproducts')

const nu = document.querySelector('.nuevo')
guardar.addEventListener('click', () => {
  let nombre = document.querySelector('.nombre').value
  let descripcion = document.querySelector('.descripcion').value



  let continuar = confirm('¿Desea continuar?');
  if (continuar) {
    // Acciones si el usuario acepta
    fetch('../cotrollador/guardarproducto.php', {
      method: 'POST',
      headers: {
        "content-type": "application/json"

      },

      mode: 'cors',
      cache: 'no-cache',
      body: JSON.stringify({ nombre: nombre, descripcion: descripcion })
    }).then(respon => respon.text()).then(datar => alert('guardado exitosament'))
    nu.style.display = "none"

    traer()
  } else {
    // Acciones si el usuario cancela
    document.querySelector('.nombre').value = ''
    document.querySelector('.descripcion').value = ''
  }


})
let cancelar = document.querySelector('.botonnuevocancelar')
cancelar.addEventListener('click', () => {
  nu.style.display = "none"
})



traer()
