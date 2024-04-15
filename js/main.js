let selector = document.querySelector("#phone")
let im = new Inputmask("+7(999) 999-99-99")
im.mask(selector)

let validation = new JustValidate("form")

validation.addField("#fio", [
  {
    rule: "required",
    errorMessage: "Введите ФИО!"
  },
  {
    rule: "minLength",
    value: 2,
    errorMessage: "Минимум 2 символа!"
  }
]).addField("#phone", [
  {
    validator: (value) => {
      const phone = selector.inputmask.unmaskedvalue()
      return Boolean(Number(phone) && phone.length > 0)
    },
    errorMessage: 'Введите телефон'
  },
  {
    validator: (value) => {
      const phone = selector.inputmask.unmaskedvalue()
      return Boolean(Number(phone) && phone.length === 10)
    },
    errorMessage: 'Введите телефон полностью'
  }
]).onSuccess(async function () {
  let data = {
    name: document.getElementById("fio").value,
    phone: selector.inputmask.unmaskedvalue()
  }

  let response = await fetch("mail.php", {
    method: "POST",
    body: JSON.stringify(data),
    headers: {
      "Content-Type": "application/json; charset=UTF-8"
    }
  })

  let result = await response.text()

  alert(result)
})
