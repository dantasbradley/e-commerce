const validation = new JustValidate("#signup");

validation
    .addField("#name", [ //rules for the name input
        {
            rule: "required" //can't be empty
        }
    ])
    .addField("#email", [ //rules for the email input
        {
            rule: "required" //can't be empty
        },
        {
            rule: "email" //built in rule checking if email valid
        },


    ])
    .addField("#password", [ //rules for the password input
        {
            rule: "required" //can't be empty
        },
        {
            rule: "password" //built in rule for password with 8+ charactes with letter and number
        }
    ])
    .addField("#password_confirmation", [ //rules for the password confimation input
        {
            validator: (value, fields) => {
                //check if password and this field is the same
                return value === fields["#password"].elem.value; 
            },
            errorMessage: "Passwords should match"
        }
    ])
    .onSuccess((event) => { //if everything good then the submit button can now send you to another page
        document.getElementById("signup").submit();
    });
    