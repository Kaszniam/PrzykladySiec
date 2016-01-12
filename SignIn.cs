using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class SignIn : MonoBehaviour {

    public string username;
    public string password;
    public string email;
    public InputField inputUsername;
    public InputField inputPassword;
    public InputField inputEmail;
    public Text errorTextPassword;
    public Text errorTextUsername;
    public Text errorTextEmail;
    public Text signedInText;
    public Button registerButton;
    private string formText = "";
    private string URL = "http://localhost/Unity/signin.php";

    void Start ()
    {
        errorTextPassword.enabled = false;
        errorTextUsername.enabled = false;
        errorTextEmail.enabled = false;
        signedInText.enabled = false;
    }

    public void onClickSignIn()
    {
        errorTextPassword.enabled = false;
        errorTextUsername.enabled = false;
        errorTextEmail.enabled = false;
        StopCoroutine(Register());
        StartCoroutine(Register());
    }

    IEnumerator Register()
    {
        username = inputUsername.text;
        password = inputPassword.text;
        email = inputEmail.text;
        WWWForm form = new WWWForm();
        form.AddField("username", username);
        form.AddField("password", password);
        form.AddField("email", email);
        WWW web = new WWW(URL, form);
        yield return web;
        formText = web.data;
        Debug.Log(formText);
        switch (formText)
        {
            case "signedin":

                signedInText.enabled = true;
                yield return new WaitForSeconds(2f);
                //Application.LoadLevel(4);
                Debug.Log(formText);
                break;

            case "Username already taken!":

                errorTextUsername.text = "Username already taken!";
                errorTextUsername.enabled = true;
                break;

            case "Username too short!":

                errorTextUsername.text = "Username too short! (min. 3)";
                errorTextUsername.enabled = true;
                break;

            case "Username too long!":

                errorTextUsername.text = "Username too long! (max. 20)";
                errorTextUsername.enabled = true;
                break;

            case "Email already taken!":

                errorTextEmail.text = "Email already taken!";
                errorTextEmail.enabled = true;
                break;

            case "Password too short!":

                errorTextPassword.text = "Password too short! (min. 5)";
                errorTextPassword.enabled = true;
                break;

            case "Password too long!":

                errorTextPassword.text = "Password too long! (max. 20)";
                errorTextPassword.enabled = true;
                break;

            case "Email cannot be empty!":

                errorTextEmail.text = "Email cannot be empty!";
                errorTextEmail.enabled = true;
                break;

            case "Please write correct email!":

                errorTextEmail.text = "Please write correct email!";
                errorTextEmail.enabled = true;
                break;

            default:

                Debug.Log("error in cases!");
                Debug.Log(formText);
                break;
        }
        username = "";
        password = "";
        email = "";
        StopCoroutine(Register());
    }
}
