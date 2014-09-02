using Microsoft.Owin;
using Owin;

[assembly: OwinStartupAttribute(typeof(git_trello_integration.Startup))]
namespace git_trello_integration
{
    public partial class Startup
    {
        public void Configuration(IAppBuilder app)
        {
            ConfigureAuth(app);
        }
    }
}
