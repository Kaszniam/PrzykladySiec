using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class LogIn : MonoBehaviour {

    public string username;
    public string password;
    public InputField inputUsername;
    public InputField inputPassword;
    public Text errorText;
    public Button loginButton;
    public Button registerButton;
    private string formText = "";
    private string URL = "http://localhost/Unity/login.php";

    void Start ()
    {
        errorText.enabled = false;
    }
	
    public void onClickLogIn()
    {
        errorText.enabled = false;
        StartCoroutine(Log());
    }

    public void onClickSignIn()
    {
      // Application.LoadLevel();
    }

   IEnumerator Log()
   {
        username = inputUsername.text;
        password = inputPassword.text;
        WWWForm form = new WWWForm();
        form.AddField("username", username);
        form.AddField("password", password);
        WWW web = new WWW(URL, form);
        yield return web;
        formText = web.data;
        Debug.Log(formText);
        switch (formText)
        {
            case "logged":
                PlayerPrefs.SetString("username", username);
               // Application.LoadLevel(); 
                break;

            case "Incorrect Username!":

                errorText.text = "Incorrect Username!";
                errorText.enabled = true;
                break;

            case "Incorrect Password!":

                errorText.text = "Incorrect Password!";
                errorText.enabled = true;
                break;

            case "Not Active!":

                errorText.text = "Account not active!";
                errorText.enabled = true;
                break;

            default:

                Debug.Log("error in cases!");
                Debug.Log(formText);
                break;
        }
        username = "";
        password = "";
        StopCoroutine(Log());
   }
}
 