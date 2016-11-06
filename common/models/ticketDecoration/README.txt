Naming Convention

Technically every Class/File should have "TicketDecoration" as part of its name. However, this became to tedious and
repetitive. I decided to shorten the names, for instance "Generic" instead of "GenericTicketDecoration".
After all what is the point of namespaces, if not to allow one to shorten some of the classes that belong to that
namespace.

Applying this thought to all the files did not please me either. Some of the classes are simple
endpoints of the concept of the namespace (Generic, MoveTo ...). Other classes, however, play a role
throughout the entire namespace, such as (TicketDecorationInterface, AbstractTicketDecoration and
TicketDecorationManager).

Thus, I have decided upon two styles for names of the classes. Classes which play a role throughout
the namespace contain "TicketDecoration" as a prefix. Other class, the implementations of the individual
decorations do not contain the prefix.